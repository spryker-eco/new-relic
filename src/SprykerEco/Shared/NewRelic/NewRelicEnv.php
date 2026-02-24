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
     * - NerdGraph GraphQL API endpoint URL.
     * - Default: https://api.newrelic.com/graphql
     *
     * @api
     *
     * @var string
     */
    public const NEW_RELIC_NERDGRAPH_API_URL = 'NEWRELIC:NEW_RELIC_NERDGRAPH_API_URL';

    /**
     * Specification:
     * - New Relic User API key for NerdGraph authentication.
     *
     * @api
     *
     * @var string
     */
    public const NEW_RELIC_USER_API_KEY = 'NEWRELIC:NEW_RELIC_USER_API_KEY';

    /**
     * Specification:
     * - Array of New Relic entity GUIDs for deployment tracking.
     *
     * @api
     *
     * @var string
     */
    public const NEW_RELIC_ENTITY_GUID_ARRAY = 'NEWRELIC:NEW_RELIC_ENTITY_GUID_ARRAY';
}
