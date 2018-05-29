<?php
/**
 * Copyright © 2018-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\NewRelic\Plugin;

use Spryker\Shared\MonitoringExtension\Dependency\Plugin\MonitoringExtensionPluginInterface;

class NewRelicMonitoringExtensionPlugin implements MonitoringExtensionPluginInterface
{
    /**
     * @var string
     */
    protected $application;

    /**
     * @param string $message
     * @param \Exception|\Throwable $exception
     *
     * @return void
     */
    public function setError(string $message, $exception): void
    {
        newrelic_notice_error($message, $exception);
    }

    /**
     * @param string $application
     * @param string $store
     * @param string $environment
     *
     * @return void
     */
    public function setAppName(string $application, string $store, string $environment): void
    {
        $this->application = $application . '-' . $store . ' (' . $environment . ')';

        newrelic_set_appname($this->application);
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setTransactionName(string $name): void
    {
        newrelic_name_transaction($name);
    }

    /**
     * @return void
     */
    public function markStartTransaction(): void
    {
        newrelic_start_transaction($this->application);
    }

    /**
     * @return void
     */
    public function markEndOfTransaction(): void
    {
        newrelic_end_transaction();
    }

    /**
     * @return void
     */
    public function markIgnoreTransaction(): void
    {
        newrelic_ignore_transaction();
    }

    /**
     * @return void
     */
    public function markAsConsoleCommand(): void
    {
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
        newrelic_add_custom_parameter($key, $value);
    }

    /**
     * @param string $tracer
     *
     * @return void
     */
    public function addCustomTracer(string $tracer): void
    {
        newrelic_add_custom_tracer($tracer);
    }
}
