<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\NewRelic\Model;

class NewRelicApi implements NewRelicApiInterface
{
    /**
     * @var bool
     */
    private bool $isActive;

    public function __construct()
    {
        $this->isActive = extension_loaded('newrelic');
    }

    /**
     * @param string $message
     * @param \Throwable $exception
     *
     * @return void
     */
    public function noticeError(string $message, \Throwable $exception): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_notice_error($message, $exception);
    }

    /**
     * @param string $appName
     * @param string|null $license
     * @param bool $xmit
     *
     * @return void
     */
    public function setAppName(string $appName, ?string $license = null, bool $xmit = false): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_set_appname($appName, $license ?? '', $xmit);
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function nameTransaction(string $name): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_name_transaction($name);
    }

    /**
     * @param string $appName
     *
     * @return void
     */
    public function startTransaction(string $appName): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_start_transaction($appName);
    }

    /**
     * @return void
     */
    public function endTransaction(): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_end_transaction();
    }

    /**
     * @return void
     */
    public function ignoreApdex(): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_ignore_apdex();
    }

    /**
     * @return void
     */
    public function ignoreTransaction(): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_ignore_transaction();
    }

    /**
     * @param bool $flag
     *
     * @return void
     */
    public function backgroundJob(bool $flag = true): void
    {
        if (!$this->isActive) {
            return;
        }

        newrelic_background_job($flag);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function addCustomParameter(string $key, mixed $value): void
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
