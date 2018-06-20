<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\NewRelic;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\NewRelic\NewRelicConstants;

class NewRelicConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getNewRelicDeploymentApiUrl(): string
    {
        return $this->get(NewRelicConstants::NEW_RELIC_DEPLOYMENT_API_URL);
    }

    /**
     * @return string
     */
    public function getNewRelicApiKey(): string
    {
        return $this->get(NewRelicConstants::NEW_RELIC_API_KEY);
    }
}
