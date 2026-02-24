<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\NewRelic;

use Spryker\Service\Kernel\AbstractServiceFactory;
use SprykerEco\Service\NewRelic\Model\NewRelicApi;
use SprykerEco\Service\NewRelic\Model\NewRelicApiInterface;

class NewRelicServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \SprykerEco\Service\NewRelic\Model\NewRelicApiInterface
     */
    public function createNewRelicApi(): NewRelicApiInterface
    {
        return new NewRelicApi();
    }
}
