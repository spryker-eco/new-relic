<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\NewRelic\Business\Model;

interface RecordDeploymentInterface
{
    /**
     * @param array<string, string> $arguments
     *
     * @throws \SprykerEco\Zed\NewRelic\Business\Exception\RecordDeploymentException
     *
     * @return void
     */
    public function recordDeployment(array $arguments = []): void;
}
