<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\NewRelic\Business\Model;

use Guzzle\Http\Client;
use Psr\Http\Message\ResponseInterface;
use SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException;

class RecordDeployment implements RecordDeploymentInterface
{
    const NEW_RELIC_DEPLOYMENT_API_URL = 'https://api.newrelic.com/deployments.xml';
    const STATUS_CODE_SUCCESS = 200;
    const STATUS_CODE_REDIRECTION = 300;

    /**
     * @var string
     */
    protected $newRelicDeploymentApiUrl;

    /**
     * @var string
     */
    protected $newRelicApiKey;

    /**
     * @param string $newRelicDeploymentApiUrl
     * @param string $newRelicApiKey
     */
    public function __construct(string $newRelicDeploymentApiUrl, string $newRelicApiKey)
    {
        $this->newRelicDeploymentApiUrl = $newRelicDeploymentApiUrl;
        $this->newRelicApiKey = $newRelicApiKey;
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

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function createRecordDeploymentRequest(array $params): ResponseInterface
    {
        $options = [
            'headers' => [
                'x-api-key' => $this->newRelicApiKey,
            ],
        ];

        $data = [];
        $data['deployment'] = [];
        foreach ($params as $key => $value) {
            $data['deployment'][$key] = $value;
        }
        $options['form_params'] = $data;

        $httpClient = new Client();

        $request = $httpClient->post($this->newRelicDeploymentApiUrl, $options);

        return $request;
    }
}
