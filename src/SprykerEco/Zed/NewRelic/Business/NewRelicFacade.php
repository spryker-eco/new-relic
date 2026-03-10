<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\NewRelic\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\NewRelic\Business\NewRelicBusinessFactory getFactory()
 */
class NewRelicFacade extends AbstractFacade implements NewRelicFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<string, string> $arguments
     *
     * @throws \SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException
     *
     * @return void
     */
    public function recordDeployment(array $arguments = []): void
    {
        $this->getFactory()->createRecordDeployment()->recordDeployment($arguments);
    }
}
