<?php

/**
 * Apache OSL-2
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SPrykerEcoTest\Service\Newrelic\Plugin;

use Codeception\Test\Unit;
use Spryker\Service\MonitoringExtension\Dependency\Plugin\MonitoringExtensionPluginInterface;
use SprykerEco\Service\NewRelic\Plugin\NewRelicMonitoringExtensionPlugin;

class NewRelicMonitoringExtensionPluginTest extends Unit
{
    /**
     * @return void
     */
    public function testExtensionPluginCanBeInstantiated(): void
    {
        $this->assertInstanceOf(MonitoringExtensionPluginInterface::class, new NewRelicMonitoringExtensionPlugin());
    }
}
