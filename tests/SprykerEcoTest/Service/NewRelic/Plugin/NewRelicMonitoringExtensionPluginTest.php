<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Service\NewRelic\Plugin;

use Codeception\Test\Unit;
use Exception;
use SprykerEco\Service\NewRelic\Model\NewRelicApiInterface;
use SprykerEco\Service\NewRelic\NewRelicServiceFactory;
use SprykerEco\Service\NewRelic\Plugin\NewRelicMonitoringExtensionPlugin;

class NewRelicMonitoringExtensionPluginTest extends Unit
{
    /**
     * @return void
     */
    public function testSetErrorDelegatesToNewRelicApi(): void
    {
        // Arrange
        $apiMock = $this->createNewRelicApiMock();
        $exception = new Exception('test');

        $apiMock->expects($this->once())
            ->method('noticeError')
            ->with('Error message', $exception);

        $plugin = $this->createPluginWithMockedFactory($apiMock);

        // Act
        $plugin->setError('Error message', $exception);
    }

    /**
     * @return void
     */
    public function testSetApplicationNameDelegatesToNewRelicApi(): void
    {
        // Arrange
        $apiMock = $this->createNewRelicApiMock();

        $apiMock->expects($this->once())
            ->method('setAppName')
            ->with('MyApp-DE (production)');

        $plugin = $this->createPluginWithMockedFactory($apiMock);

        // Act
        $plugin->setApplicationName('MyApp', 'DE', 'production');
    }

    /**
     * @return void
     */
    public function testSetTransactionNameDelegatesToNewRelicApi(): void
    {
        // Arrange
        $apiMock = $this->createNewRelicApiMock();

        $apiMock->expects($this->once())
            ->method('nameTransaction')
            ->with('catalog/search');

        $plugin = $this->createPluginWithMockedFactory($apiMock);

        // Act
        $plugin->setTransactionName('catalog/search');
    }

    /**
     * @return void
     */
    public function testMarkStartTransactionDelegatesToNewRelicApi(): void
    {
        // Arrange
        $apiMock = $this->createNewRelicApiMock();

        $apiMock->expects($this->once())
            ->method('startTransaction')
            ->with('');

        $plugin = $this->createPluginWithMockedFactory($apiMock);

        // Act
        $plugin->markStartTransaction();
    }

    /**
     * @return void
     */
    public function testMarkEndOfTransactionDelegatesToNewRelicApi(): void
    {
        // Arrange
        $apiMock = $this->createNewRelicApiMock();

        $apiMock->expects($this->once())
            ->method('endTransaction');

        $plugin = $this->createPluginWithMockedFactory($apiMock);

        // Act
        $plugin->markEndOfTransaction();
    }

    /**
     * @return void
     */
    public function testMarkIgnoreTransactionDelegatesToNewRelicApi(): void
    {
        // Arrange
        $apiMock = $this->createNewRelicApiMock();

        $apiMock->expects($this->once())
            ->method('ignoreApdex');
        $apiMock->expects($this->once())
            ->method('ignoreTransaction');

        $plugin = $this->createPluginWithMockedFactory($apiMock);

        // Act
        $plugin->markIgnoreTransaction();
    }

    /**
     * @return void
     */
    public function testMarkAsConsoleCommandDelegatesToNewRelicApi(): void
    {
        // Arrange
        $apiMock = $this->createNewRelicApiMock();

        $apiMock->expects($this->once())
            ->method('backgroundJob')
            ->with(true);

        $plugin = $this->createPluginWithMockedFactory($apiMock);

        // Act
        $plugin->markAsConsoleCommand();
    }

    /**
     * @return void
     */
    public function testAddCustomParameterDelegatesToNewRelicApi(): void
    {
        // Arrange
        $apiMock = $this->createNewRelicApiMock();

        $apiMock->expects($this->once())
            ->method('addCustomParameter')
            ->with('key', 'value');

        $plugin = $this->createPluginWithMockedFactory($apiMock);

        // Act
        $plugin->addCustomParameter('key', 'value');
    }

    /**
     * @return void
     */
    public function testAddCustomTracerDelegatesToNewRelicApi(): void
    {
        // Arrange
        $apiMock = $this->createNewRelicApiMock();

        $apiMock->expects($this->once())
            ->method('addCustomTracer')
            ->with('MyClass::myMethod');

        $plugin = $this->createPluginWithMockedFactory($apiMock);

        // Act
        $plugin->addCustomTracer('MyClass::myMethod');
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerEco\Service\NewRelic\Model\NewRelicApiInterface
     */
    protected function createNewRelicApiMock(): NewRelicApiInterface
    {
        return $this->createMock(NewRelicApiInterface::class);
    }

    /**
     * @param \SprykerEco\Service\NewRelic\Model\NewRelicApiInterface $apiMock
     *
     * @return \SprykerEco\Service\NewRelic\Plugin\NewRelicMonitoringExtensionPlugin
     */
    protected function createPluginWithMockedFactory(NewRelicApiInterface $apiMock): NewRelicMonitoringExtensionPlugin
    {
        $factoryMock = $this->createMock(NewRelicServiceFactory::class);
        $factoryMock->method('createNewRelicApi')->willReturn($apiMock);

        $plugin = new NewRelicMonitoringExtensionPlugin();
        $plugin->setFactory($factoryMock);

        return $plugin;
    }
}
