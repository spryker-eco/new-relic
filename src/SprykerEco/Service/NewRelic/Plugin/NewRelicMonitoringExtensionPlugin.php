<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\NewRelic\Plugin;

use Spryker\Service\Kernel\AbstractPlugin;
use Spryker\Service\MonitoringExtension\Dependency\Plugin\MonitoringExtensionPluginInterface;
use SprykerEco\Service\NewRelic\Model\NewRelicApiInterface;

/**
 * @method \SprykerEco\Service\NewRelic\NewRelicServiceFactory getFactory()
 */
class NewRelicMonitoringExtensionPlugin extends AbstractPlugin implements MonitoringExtensionPluginInterface
{
    /**
     * @var string
     */
    protected string $application = '';

    /**
     * @var \SprykerEco\Service\NewRelic\Model\NewRelicApiInterface|null
     */
    protected ?NewRelicApiInterface $newRelicApi = null;

    /**
     * @param string $message
     * @param \Exception|\Throwable $exception
     *
     * @return void
     */
    public function setError(string $message, $exception): void
    {
        $this->getNewRelicApi()->noticeError($message, $exception);
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
        $this->application = $application . '-' . $store . ' (' . $environment . ')';

        $this->getNewRelicApi()->setAppName($this->application);
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setTransactionName(string $name): void
    {
        $this->getNewRelicApi()->nameTransaction($name);
    }

    /**
     * @return void
     */
    public function markStartTransaction(): void
    {
        $this->getNewRelicApi()->startTransaction($this->application);
    }

    /**
     * @return void
     */
    public function markEndOfTransaction(): void
    {
        $this->getNewRelicApi()->endTransaction();
    }

    /**
     * @return void
     */
    public function markIgnoreTransaction(): void
    {
        $this->getNewRelicApi()->ignoreApdex();
        $this->getNewRelicApi()->ignoreTransaction();
    }

    /**
     * @return void
     */
    public function markAsConsoleCommand(): void
    {
        $this->getNewRelicApi()->backgroundJob(true);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function addCustomParameter(string $key, $value): void
    {
        $this->getNewRelicApi()->addCustomParameter($key, $value);
    }

    /**
     * @param string $tracer
     *
     * @return void
     */
    public function addCustomTracer(string $tracer): void
    {
        $this->getNewRelicApi()->addCustomTracer($tracer);
    }

    /**
     * @return \SprykerEco\Service\NewRelic\Model\NewRelicApiInterface
     */
    protected function getNewRelicApi(): NewRelicApiInterface
    {
        if ($this->newRelicApi === null) {
            $this->newRelicApi = $this->getFactory()->createNewRelicApi();
        }

        /** @var \SprykerEco\Service\NewRelic\Model\NewRelicApiInterface */
        return $this->newRelicApi;
    }
}
