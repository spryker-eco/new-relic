<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\NewRelic;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\NewRelic\NewRelicEnv;

class NewRelicConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getNewRelicDeploymentApiUrl(): string
    {
        return $this->get(NewRelicEnv::NEW_RELIC_DEPLOYMENT_API_URL);
    }

    /**
     * @return string
     */
    public function getNewRelicApiKey(): string
    {
        return $this->get(NewRelicEnv::NEW_RELIC_API_KEY);
    }
}
