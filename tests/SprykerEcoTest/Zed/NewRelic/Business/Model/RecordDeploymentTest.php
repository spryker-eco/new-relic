<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\NewRelic\Business\Model;

use Codeception\Test\Unit;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException;
use SprykerEco\Zed\NewRelic\Business\Model\RecordDeployment;

class RecordDeploymentTest extends Unit
{
    /**
     * @var string
     */
    protected const NERDGRAPH_API_URL = 'https://api.newrelic.com/graphql';

    /**
     * @var string
     */
    protected const USER_API_KEY = 'NRAK-TEST123';

    /**
     * @return void
     */
    public function testRecordDeploymentSendsGraphQlMutationForEachEntityGuid(): void
    {
        // Arrange
        $entityGuids = ['MXxBUE18QVBQTElDQVRJT058MTIzNA', 'MXxBUE18QVBQTElDQVRJT058NTY3OA'];

        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock->expects($this->exactly(2))
            ->method('request')
            ->with(
                'POST',
                static::NERDGRAPH_API_URL,
                $this->callback(function (array $options) {
                    $this->assertSame('application/json', $options['headers']['Content-Type']);
                    $this->assertSame(static::USER_API_KEY, $options['headers']['API-Key']);
                    $this->assertArrayHasKey('query', $options['json']);
                    $this->assertStringContainsString('changeTrackingCreateDeployment', $options['json']['query']);

                    return true;
                }),
            )
            ->willReturn(new Response(200, [], json_encode([
                'data' => ['changeTrackingCreateDeployment' => ['deploymentId' => '123']],
            ])));

        $recordDeployment = new RecordDeployment(
            static::NERDGRAPH_API_URL,
            static::USER_API_KEY,
            $entityGuids,
            $httpClientMock,
        );

        // Act
        $recordDeployment->recordDeployment(['revision' => 'abc123']);
    }

    /**
     * @return void
     */
    public function testRecordDeploymentMapsRevisionToVersionAndCommit(): void
    {
        // Arrange
        $entityGuids = ['MXxBUE18QVBQTElDQVRJT058MTIzNA'];

        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                static::NERDGRAPH_API_URL,
                $this->callback(function (array $options) {
                    $query = $options['json']['query'];
                    $this->assertStringContainsString('version: "v1.2.3"', $query);
                    $this->assertStringContainsString('commit: "v1.2.3"', $query);
                    $this->assertStringContainsString('user: "deployer"', $query);
                    $this->assertStringContainsString('description: "My deploy"', $query);
                    $this->assertStringContainsString('changelog: "Fixed bugs"', $query);

                    return true;
                }),
            )
            ->willReturn(new Response(200, [], json_encode([
                'data' => ['changeTrackingCreateDeployment' => ['deploymentId' => '123']],
            ])));

        $recordDeployment = new RecordDeployment(
            static::NERDGRAPH_API_URL,
            static::USER_API_KEY,
            $entityGuids,
            $httpClientMock,
        );

        // Act
        $recordDeployment->recordDeployment([
            'revision' => 'v1.2.3',
            'user' => 'deployer',
            'description' => 'My deploy',
            'changelog' => 'Fixed bugs',
        ]);
    }

    /**
     * @return void
     */
    public function testRecordDeploymentThrowsExceptionOnHttpError(): void
    {
        // Arrange
        $entityGuids = ['MXxBUE18QVBQTElDQVRJT058MTIzNA'];

        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock->method('request')
            ->willReturn(new Response(500, [], 'Internal Server Error'));

        $recordDeployment = new RecordDeployment(
            static::NERDGRAPH_API_URL,
            static::USER_API_KEY,
            $entityGuids,
            $httpClientMock,
        );

        // Assert
        $this->expectException(RecordDeploymentException::class);
        $this->expectExceptionMessageMatches('/failed with code 500/');

        // Act
        $recordDeployment->recordDeployment(['revision' => 'abc123']);
    }

    /**
     * @return void
     */
    public function testRecordDeploymentThrowsExceptionOnGraphQlError(): void
    {
        // Arrange
        $entityGuids = ['MXxBUE18QVBQTElDQVRJT058MTIzNA'];

        $responseBody = json_encode([
            'errors' => [
                ['message' => 'Entity not found'],
            ],
        ]);

        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock->method('request')
            ->willReturn(new Response(200, [], $responseBody));

        $recordDeployment = new RecordDeployment(
            static::NERDGRAPH_API_URL,
            static::USER_API_KEY,
            $entityGuids,
            $httpClientMock,
        );

        // Assert
        $this->expectException(RecordDeploymentException::class);
        $this->expectExceptionMessageMatches('/Entity not found/');

        // Act
        $recordDeployment->recordDeployment(['revision' => 'abc123']);
    }

    /**
     * @return void
     */
    public function testRecordDeploymentDoesNothingWithEmptyEntityGuids(): void
    {
        // Arrange
        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock->expects($this->never())->method('request');

        $recordDeployment = new RecordDeployment(
            static::NERDGRAPH_API_URL,
            static::USER_API_KEY,
            [],
            $httpClientMock,
        );

        // Act
        $recordDeployment->recordDeployment(['revision' => 'abc123']);
    }
}
