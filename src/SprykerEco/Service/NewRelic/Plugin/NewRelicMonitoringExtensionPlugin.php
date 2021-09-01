<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\NewRelic\Plugin;

use Spryker\Service\Kernel\AbstractPlugin;
use Spryker\Service\MonitoringExtension\Dependency\Plugin\MonitoringExtensionPluginInterface;

/**
 * @method \SprykerEco\Service\NewRelic\NewRelicServiceInterface getService()
 */
class NewRelicMonitoringExtensionPlugin extends AbstractPlugin implements MonitoringExtensionPluginInterface
{
    /**
     * @param string $message
     * @param \Exception|\Throwable $exception
     *
     * @return void
     */
    public function setError(string $message, $exception): void
    {
        $this->getService()->setError($message, $exception);
    }

    /**
     * @param string|null $application
     * @param string|null $store
     * @param string|null $environment
     *
     * @return void
     */
    public function setApplicationName(?string $application = null, ?string $store = null, ?string $environment = null): void
    {
        $this->getService()->setApplicationName($application, $store, $environment);
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setTransactionName(string $name): void
    {
        $this->getService()->setTransactionName($name);
    }

    /**
     * @return void
     */
    public function markStartTransaction(): void
    {
        $this->getService()->markStartTransaction();
    }

    /**
     * @return void
     */
    public function markEndOfTransaction(): void
    {
        $this->getService()->markEndOfTransaction();
    }

    /**
     * @return void
     */
    public function markIgnoreTransaction(): void
    {
        $this->getService()->markIgnoreTransaction();
    }

    /**
     * @return void
     */
    public function markAsConsoleCommand(): void
    {
        $this->getService()->markAsConsoleCommand();
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function addCustomParameter(string $key, $value): void
    {
        $this->getService()->addCustomParameter($key, $value);
    }

    /**
     * @param string $tracer
     *
     * @return void
     */
    public function addCustomTracer(string $tracer): void
    {
        $this->getService()->addCustomTracer($tracer);
    }
}
