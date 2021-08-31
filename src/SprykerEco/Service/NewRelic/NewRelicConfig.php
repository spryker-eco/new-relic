<?php

namespace SprykerEco\Service\NewRelic;

use Spryker\Service\Kernel\AbstractBundleConfig;

class NewRelicConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getDefaultTransactionName(): string
    {
        return APPLICATION . ':' . $_SERVER['REQUEST_METHOD'] . (strtok($_SERVER['REQUEST_URI'], '?') ?: '/');
    }
}
