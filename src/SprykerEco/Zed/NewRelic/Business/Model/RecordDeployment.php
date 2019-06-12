<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\NewRelic\Business\Model;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException;

class RecordDeployment implements RecordDeploymentInterface
{
    const STATUS_CODE_SUCCESS = 200;
    const STATUS_CODE_REDIRECTION = 300;

    /**
     * @var string
     *
     * @example https://api.eu.newrelic.com/v2/applications/12345/deployments.json
     * @example https://api.eu.newrelic.com/v2/applications/%s/deployments.json
     *
     * @see https://docs.newrelic.com/docs/apm/new-relic-apm/maintenance/record-deployments
     */
    protected $newRelicDeploymentApiUrl;

    /**
     * @var string
     */
    protected $newRelicApiKey;

    /**
     * @var array
     */
    protected $newRelicApplicationIds;

    /**
     * @param string $newRelicDeploymentApiUrl
     * @param string $newRelicApiKey
     * @param array $newRelicApplicationIds
     */
    public function __construct(
        string $newRelicDeploymentApiUrl,
        string $newRelicApiKey,
        array $newRelicApplicationIds = []
    )
    {
        $this->newRelicDeploymentApiUrl = $newRelicDeploymentApiUrl;
        $this->newRelicApiKey = $newRelicApiKey;
        $this->newRelicApplicationIds = $newRelicApplicationIds;
    }

    /**
     * @param array $arguments
     *
     * @throws \SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException
     *
     * @return $this
     */
    public function recordDeployment(array $arguments = []): RecordDeploymentInterface
    {
        if (empty($this->newRelicApplicationIds)) {
            return $this->recordSingleDeployment($arguments);
        }

        foreach ($this->newRelicApplicationIds as $singleApplicationId) {
            $arguments['application_id'] = $singleApplicationId;
            $this->recordSingleDeployment($arguments);
        }

        return $this;

    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function createRecordDeploymentRequest(array $params): ResponseInterface
    {
        $applicationId = $params['application_id'] ?? null;

        unset($params['app_name']);
        unset($params['application_id']);

        $options = [
            'headers' => [
                'X-Api-Key' => $this->newRelicApiKey,
            ],
            'json' => [
                'deployment' => $params,
            ],
        ];

        $httpClient = new Client();

        $deploymentUrl = $this->newRelicDeploymentApiUrl;
        if ($applicationId) {
            $deploymentUrl = sprintf($this->newRelicDeploymentApiUrl, $applicationId);
        }

        $request = $httpClient->post($deploymentUrl, $options);

        return $request;
    }

    /**
     * @param array $arguments
     *
     * @throws \SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException
     *
     * @return $this
     */
    private function recordSingleDeployment(array $arguments=[]): RecordDeploymentInterface
    {
        $response = $this->createRecordDeploymentRequest($arguments);
        $statusCode = $response->getStatusCode();
        if ($statusCode < static::STATUS_CODE_SUCCESS || $statusCode >= static::STATUS_CODE_REDIRECTION) {
            throw new RecordDeploymentException(sprintf(
                'Record deployment to New Relic request failed with code %d. %s',
                $response->getStatusCode(),
                $response->getBody()
            ));
        }

        return $this;
    }
}
