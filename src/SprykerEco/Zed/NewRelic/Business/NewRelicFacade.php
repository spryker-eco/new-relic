<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\NewRelic\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;
use SprykerEco\Zed\NewRelic\Business\Model\RecordDeploymentInterface;

/**
 * @method \SprykerEco\Zed\NewRelic\Business\NewRelicBusinessFactory getFactory()
 */
class NewRelicFacade extends AbstractFacade implements NewRelicFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $arguments
     *
     * @return \SprykerEco\Zed\NewRelic\Business\Model\RecordDeploymentInterface
     */
    public function recordDeployment(array $arguments = []): RecordDeploymentInterface
    {
        return $this->getFactory()->createRecordDeployment()->recordDeployment($arguments);
    }
}
