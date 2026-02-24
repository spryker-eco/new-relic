<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\NewRelic\Plugin;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Service\Kernel\AbstractPlugin;
use Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface;
use Spryker\Shared\ApplicationExtension\Dependency\Plugin\BootableApplicationPluginInterface;

/**
 * @method \SprykerEco\Service\NewRelic\NewRelicServiceFactory getFactory()
 * @method \SprykerEco\Service\NewRelic\NewRelicConfig getConfig()
 */
class NewRelicTransactionNameHandlerPlugin extends AbstractPlugin implements ApplicationPluginInterface, BootableApplicationPluginInterface
{
    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    public function provide(ContainerInterface $container): ContainerInterface
    {
        return $container;
    }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    public function boot(ContainerInterface $container): ContainerInterface
    {
        $this->getFactory()
            ->createNewRelicApi()
            ->nameTransaction($this->getConfig()->getDefaultTransactionName());

        return $container;
    }
}
