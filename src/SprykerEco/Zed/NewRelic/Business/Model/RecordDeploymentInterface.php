<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\NewRelic\Business\Model;

interface RecordDeploymentInterface
{
    /**
     * @param array $arguments
     *
     * @throws \SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException
     *
     * @return $this
     */
    public function recordDeployment(array $arguments = []);
}
