<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Service\NewRelic\Model;

use Codeception\Test\Unit;
use Exception;
use SprykerEco\Service\NewRelic\Model\NewRelicApi;

class NewRelicApiTest extends Unit
{
    /**
     * @return void
     */
    public function testNoticeErrorDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert - should not throw
        $api->noticeError('test', new Exception('test'));
    }

    /**
     * @return void
     */
    public function testSetAppNameDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert
        $api->setAppName('test-app');
    }

    /**
     * @return void
     */
    public function testNameTransactionDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert
        $api->nameTransaction('test/transaction');
    }

    /**
     * @return void
     */
    public function testStartTransactionDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert
        $api->startTransaction('test-app');
    }

    /**
     * @return void
     */
    public function testEndTransactionDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert
        $api->endTransaction();
    }

    /**
     * @return void
     */
    public function testIgnoreApdexDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert
        $api->ignoreApdex();
    }

    /**
     * @return void
     */
    public function testIgnoreTransactionDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert
        $api->ignoreTransaction();
    }

    /**
     * @return void
     */
    public function testBackgroundJobDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert
        $api->backgroundJob(true);
    }

    /**
     * @return void
     */
    public function testAddCustomParameterDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert
        $api->addCustomParameter('key', 'value');
    }

    /**
     * @return void
     */
    public function testAddCustomTracerDoesNotThrowWhenExtensionNotLoaded(): void
    {
        // Arrange
        $api = new NewRelicApi();

        // Act & Assert
        $api->addCustomTracer('MyClass::myMethod');
    }
}
