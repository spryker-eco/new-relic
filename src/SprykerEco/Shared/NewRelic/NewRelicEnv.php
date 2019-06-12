<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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


    /**
     * Specification:
     * - NewRelic Application ID array
     *
     * @api
     */
    const NEW_RELIC_APPLICATION_ID_ARRAY = 'NEWRELIC:NEW_RELIC_APPLICATION_ID_ARRAY';
}
