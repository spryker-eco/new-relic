# Upgrading from 2.x to 3.0

## Breaking Changes

### PHP Requirement

- **2.x**: PHP >= 7.3
- **3.x**: PHP >= 8.3

### Deployment Recording: REST API v2 to NerdGraph GraphQL

The New Relic REST API v2 (and its API keys) reached **EOL on March 1, 2025**. Version 3.x migrates deployment recording to the [NerdGraph GraphQL API](https://docs.newrelic.com/docs/change-tracking/change-tracking-graphql/).

**Environment variable changes:**

| 2.x (removed) | 3.x (new) | Description |
|---|---|---|
| `NEWRELIC:NEW_RELIC_DEPLOYMENT_API_URL` | `NEWRELIC:NEW_RELIC_NERDGRAPH_API_URL` | API endpoint (default: `https://api.newrelic.com/graphql`) |
| `NEWRELIC:NEW_RELIC_API_KEY` | `NEWRELIC:NEW_RELIC_USER_API_KEY` | Authentication key (User API key instead of REST API key) |
| `NEWRELIC:NEW_RELIC_APPLICATION_ID_ARRAY` | `NEWRELIC:NEW_RELIC_ENTITY_GUID_ARRAY` | Entity identifiers (entity GUIDs instead of application IDs) |

**Config method changes in `NewRelicConfig` (Zed):**

| 2.x (removed) | 3.x (new) |
|---|---|
| `getNewRelicDeploymentApiUrl()` | `getNerdGraphApiUrl()` |
| `getNewRelicApiKey()` | `getUserApiKey()` |
| `getNewRelicApplicationIdArray()` | `getEntityGuidArray()` |

**Console command changes:**

The `newrelic:record-deployment` command arguments changed:

| 2.x | 3.x |
|---|---|
| `app_name` (required) | Removed (entity GUIDs come from env config) |
| `revision` (required) | `revision` (required) |
| `user` (optional) | `user` (optional) |
| `description` (optional) | `description` (optional) |
| `changelog` (optional) | `changelog` (optional) |

**Migration steps:**
1. Generate a [New Relic User API key](https://docs.newrelic.com/docs/apis/intro-apis/new-relic-api-keys/) (replaces the old REST API key)
2. Find your entity GUIDs in the New Relic UI (replaces application IDs)
3. Set the new environment variables in your deploy configuration
4. Update any project-level `NewRelicConfig` overrides to use the new method names

### Facade Return Type

- **2.x**: `NewRelicFacade::recordDeployment()` returned `RecordDeploymentInterface`
- **3.x**: `NewRelicFacade::recordDeployment()` returns `void`

### Service Layer Architecture

- **2.x**: `NewRelicMonitoringExtensionPlugin` called `newrelic_*` PHP functions directly inline
- **3.x**: Plugin delegates to `NewRelicServiceFactory::createNewRelicApi()` which returns a `NewRelicApiInterface` model

If you extended `NewRelicMonitoringExtensionPlugin` in your project, update your code to use the factory pattern:

```php
// 2.x - direct function calls
newrelic_name_transaction($name);

// 3.x - via factory model
$this->getFactory()->createNewRelicApi()->nameTransaction($name);
```

## New Features

### Optional: Default Transaction Name Plugin
Spryker's `spryker/monitoring` module already sets route-based transaction names via `ControllerListener` plugins (e.g. `homepage`, `Product/List/Index`, `storefront-api.catalog-search`). This works well for requests that reach a controller.

However, requests that never reach routing — 404s, middleware rejections, health checks, early errors — fall back to New Relic's generic auto-naming (e.g. `WebTransaction/Action/index`), making them hard to identify.

The new **optional** `NewRelicTransactionNameHandlerPlugin` sets a meaningful default at boot time, before routing:

```
YVES:GET/en/cart
ZED:POST/api/products
GLUE:GET/catalog-search
```

Format: `APPLICATION:HTTP_METHOD/path`

For normal requests, the route-based name from `ControllerListener` overwrites this default later. For requests that never reach a controller, this default remains — giving visibility into otherwise unnamed transactions.

**This plugin is optional.** The module works without it, just like 2.x. To enable it, register it in the application plugins list. For Yves, add it to `ShopApplicationDependencyProvider`:

```php
// src/Pyz/Yves/ShopApplication/ShopApplicationDependencyProvider.php

use SprykerEco\Service\NewRelic\Plugin\NewRelicTransactionNameHandlerPlugin;

protected function getApplicationPlugins(): array
{
    return [
        new YvesHttpApplicationPlugin(),
        // ... other plugins
        new NewRelicTransactionNameHandlerPlugin(), // should be registered early, before RouterApplicationPlugin
    ];
}
```

The same approach applies to Zed (`ApplicationDependencyProvider`) and Glue (`GlueBackendApiApplication`/`GlueStorefrontApiApplication` dependency providers).
