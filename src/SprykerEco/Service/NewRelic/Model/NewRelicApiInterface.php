<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\NewRelic\Model;

interface NewRelicApiInterface
{
    /**
     * @param string $message
     * @param \Throwable $exception
     *
     * @return void
     */
    public function noticeError(string $message, \Throwable $exception): void;

    /**
     * @param string $appName
     * @param string|null $license
     * @param bool $xmit
     *
     * @return void
     */
    public function setAppName(string $appName, ?string $license = null, bool $xmit = false): void;

    /**
     * @param string $name
     *
     * @return void
     */
    public function nameTransaction(string $name): void;

    /**
     * @param string $appName
     *
     * @return void
     */
    public function startTransaction(string $appName): void;

    /**
     * @return void
     */
    public function endTransaction(): void;

    /**
     * @return void
     */
    public function ignoreApdex(): void;

    /**
     * @return void
     */
    public function ignoreTransaction(): void;

    /**
     * @param bool $flag
     *
     * @return void
     */
    public function backgroundJob(bool $flag = true): void;

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function addCustomParameter(string $key, mixed $value): void;

    /**
     * @param string $tracer
     *
     * @return void
     */
    public function addCustomTracer(string $tracer): void;
}
