<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Service\Newrelic\Plugin;

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
