<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\NewRelic\Business\Model;

use GuzzleHttp\ClientInterface;
use SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException;

class RecordDeployment implements RecordDeploymentInterface
{
    /**
     * @var string
     */
    protected const MUTATION_TEMPLATE = <<<'GRAPHQL'
mutation {
    changeTrackingCreateDeployment(deployment: {version: "%s", entityGuid: "%s"%s}) {
        deploymentId
    }
}
GRAPHQL;

    /**
     * @param string $nerdGraphApiUrl
     * @param string $userApiKey
     * @param array<string> $entityGuids
     * @param \GuzzleHttp\ClientInterface $httpClient
     */
    public function __construct(
        protected readonly string $nerdGraphApiUrl,
        protected readonly string $userApiKey,
        protected readonly array $entityGuids,
        protected readonly ClientInterface $httpClient,
    ) {
    }

    /**
     * @param array<string, string> $arguments
     *
     * @throws \SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException
     *
     * @return void
     */
    public function recordDeployment(array $arguments = []): void
    {
        foreach ($this->entityGuids as $entityGuid) {
            $this->recordSingleDeployment($entityGuid, $arguments);
        }
    }

    /**
     * @param string $entityGuid
     * @param array<string, string> $arguments
     *
     * @throws \SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException
     *
     * @return void
     */
    protected function recordSingleDeployment(string $entityGuid, array $arguments): void
    {
        $mutation = $this->buildMutation($entityGuid, $arguments);

        $response = $this->httpClient->request('POST', $this->nerdGraphApiUrl, [
            'headers' => [
                'Content-Type' => 'application/json',
                'API-Key' => $this->userApiKey,
            ],
            'json' => [
                'query' => $mutation,
            ],
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode >= 300) {
            throw new RecordDeploymentException(sprintf(
                'Record deployment to New Relic request failed with code %d. %s',
                $statusCode,
                $response->getBody(),
            ));
        }

        $body = json_decode((string)$response->getBody(), true);

        if (!empty($body['errors'])) {
            $errorMessages = array_map(
                static fn (array $error): string => $error['message'] ?? 'Unknown error',
                $body['errors'],
            );

            throw new RecordDeploymentException(sprintf(
                'NerdGraph deployment recording failed: %s',
                implode('; ', $errorMessages),
            ));
        }
    }

    /**
     * @param string $entityGuid
     * @param array<string, string> $arguments
     *
     * @return string
     */
    protected function buildMutation(string $entityGuid, array $arguments): string
    {
        $version = $this->escapeGraphQl($arguments['revision'] ?? '');

        $optionalFields = '';

        if (!empty($arguments['user'])) {
            $optionalFields .= sprintf(', user: "%s"', $this->escapeGraphQl($arguments['user']));
        }

        if (!empty($arguments['description'])) {
            $optionalFields .= sprintf(', description: "%s"', $this->escapeGraphQl($arguments['description']));
        }

        if (!empty($arguments['changelog'])) {
            $optionalFields .= sprintf(', changelog: "%s"', $this->escapeGraphQl($arguments['changelog']));
        }

        if (!empty($arguments['revision'])) {
            $optionalFields .= sprintf(', commit: "%s"', $this->escapeGraphQl($arguments['revision']));
        }

        return sprintf(
            static::MUTATION_TEMPLATE,
            $version,
            $this->escapeGraphQl($entityGuid),
            $optionalFields,
        );
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function escapeGraphQl(string $value): string
    {
        return addcslashes($value, '"\\');
    }
}
