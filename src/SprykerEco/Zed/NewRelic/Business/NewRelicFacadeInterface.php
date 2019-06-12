<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\NewRelic\Business;

use SprykerEco\Zed\NewRelic\Business\Model\RecordDeploymentInterface;

/**
 * @method \SprykerEco\Zed\NewRelic\Business\NewRelicBusinessFactory getFactory()
 */
interface NewRelicFacadeInterface
{
    /**
     * Specification:
     * - Sends a record deployment to NewRelic.
     *
     * @api
     *
     * @param array $arguments
     *
     * @throws \SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException
     *
     * @return \SprykerEco\Zed\NewRelic\Business\Model\RecordDeploymentInterface
     */
    public function recordDeployment(array $arguments = []): RecordDeploymentInterface;
}
