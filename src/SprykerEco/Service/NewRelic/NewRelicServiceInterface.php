<?php

namespace SprykerEco\Service\NewRelic;

interface NewRelicServiceInterface
{
    /**
     * @param string $message
     * @param \Exception|\Throwable $exception
     *
     * @return void
     */
    public function setError(string $message, $exception): void;

    /**
     * @param string|null $application
     * @param string|null $store
     * @param string|null $environment
     *
     * @return void
     */
    public function setApplicationName(?string $application = null, ?string $store = null, ?string $environment = null): void;

    /**
     * @param string $name
     *
     * @return void
     */
    public function setTransactionName(string $name): void;

    /**
     * @return void
     */
    public function markStartTransaction(): void;

    /**
     * @return void
     */
    public function markEndOfTransaction(): void;

    /**
     * @return void
     */
    public function markIgnoreTransaction(): void;

    /**
     * @return void
     */
    public function markAsConsoleCommand(): void;

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function addCustomParameter(string $key, $value): void;

    /**
     * @param string $tracer
     *
     * @return void
     */
    public function addCustomTracer(string $tracer): void;
}
