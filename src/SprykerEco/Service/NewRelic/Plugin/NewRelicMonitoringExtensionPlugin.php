<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\NewRelic\Plugin;

use Spryker\Service\MonitoringExtension\Dependency\Plugin\MonitoringExtensionPluginInterface;

class NewRelicMonitoringExtensionPlugin implements MonitoringExtensionPluginInterface
{
    /**
     * @var string
     */
    protected $application;

    /**
     * @var bool
     */
    protected $isActive;

    public function __construct()
    {
        $this->isActive = extension_loaded('newrelic');
    }

    /**
     * @param string $message
     * @param \Exception|\Throwable $exception
     *
     * @return void
     */
    public function setError(string $message, $exception): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_notice_error($message, $exception);
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
        if (!$this->isActive) {
            return;
        }

        $this->application = $application . '-' . $store . ' (' . $environment . ')';

        newrelic_set_appname($this->application, null, false);
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setTransactionName(string $name): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_name_transaction($name);
    }

    /**
     * @return void
     */
    public function markStartTransaction(): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_start_transaction($this->application);
    }

    /**
     * @return void
     */
    public function markEndOfTransaction(): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_end_transaction();
    }

    /**
     * @return void
     */
    public function markIgnoreTransaction(): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_ignore_apdex();
        newrelic_ignore_transaction();
    }

    /**
     * @return void
     */
    public function markAsConsoleCommand(): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_background_job(true);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function addCustomParameter(string $key, $value): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_add_custom_parameter($key, $value);
    }

    /**
     * @param string $tracer
     *
     * @return void
     */
    public function addCustomTracer(string $tracer): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_add_custom_tracer($tracer);
    }
}
