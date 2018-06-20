<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\NewRelic\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\NewRelic\Business\Model\RecordDeployment;
use SprykerEco\Zed\NewRelic\Business\Model\RecordDeploymentInterface;

/**
 * @method \SprykerEco\Zed\NewRelic\NewRelicConfig getConfig()
 */
class NewRelicBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\NewRelic\Business\Model\RecordDeploymentInterface
     */
    public function createRecordDeployment(): RecordDeploymentInterface
    {
        return new RecordDeployment(
            $this->getConfig()->getNewRelicDeploymentApiUrl(),
            $this->getConfig()->getNewRelicApiKey()
        );
    }
}
