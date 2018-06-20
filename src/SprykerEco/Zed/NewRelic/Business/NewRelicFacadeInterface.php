<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @return \SprykerEco\Zed\NewRelic\Business\Model\RecordDeploymentInterface
     */
    public function recordDeployment(array $arguments = []): RecordDeploymentInterface;
}
