<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\NewRelic\Business;

/**
 * @method \SprykerEco\Zed\NewRelic\Business\NewRelicBusinessFactory getFactory()
 */
interface NewRelicFacadeInterface
{
    /**
     * Specification:
     * - Sends deployment tracking records to New Relic via NerdGraph GraphQL API.
     * - Records a deployment for each configured entity GUID.
     *
     * @api
     *
     * @param array<string, string> $arguments
     *
     * @throws \SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException
     *
     * @return void
     */
    public function recordDeployment(array $arguments = []): void;
}
