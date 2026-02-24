<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\NewRelic;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\NewRelic\NewRelicEnv;

class NewRelicConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const DEFAULT_NERDGRAPH_API_URL = 'https://api.newrelic.com/graphql';

    /**
     * @api
     *
     * @return string
     */
    public function getNerdGraphApiUrl(): string
    {
        return $this->get(NewRelicEnv::NEW_RELIC_NERDGRAPH_API_URL, static::DEFAULT_NERDGRAPH_API_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getUserApiKey(): string
    {
        return $this->get(NewRelicEnv::NEW_RELIC_USER_API_KEY);
    }

    /**
     * @api
     *
     * @return array<string>
     */
    public function getEntityGuidArray(): array
    {
        return $this->get(NewRelicEnv::NEW_RELIC_ENTITY_GUID_ARRAY, []);
    }
}
