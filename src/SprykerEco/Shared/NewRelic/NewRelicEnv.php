<?php

/**
 * Apache OSL-2
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\NewRelic;

interface NewRelicEnv
{
    /**
     * Specification:
     * - NewRelic record deployment url.
     *
     * @api
     */
    const NEW_RELIC_DEPLOYMENT_API_URL = 'NEWRELIC:NEW_RELIC_DEPLOYMENT_API_URL';

    /**
     * Specification:
     * - NewRelic api key.
     *
     * @api
     */
    const NEW_RELIC_API_KEY = 'NEWRELIC:NEW_RELIC_API_KEY';
}
