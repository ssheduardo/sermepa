# Changelog

All Notable changes to `Redsys` will be documented in this file

## Version 2.0.0 (2026-10-31)

Security hardening release. The public API is unchanged, no dependency changed and PHP 7.1.3+ is still supported, but three defaults now behave differently: read the breaking changes before upgrading. If you only use the redirect flow (`createForm()` / `executeRedirection()` / InSite forms), the upgrade is drop-in.

### Breaking changes

- **TLS verification is now enforced** in `Tpv::send()` and `Tpv::sendInSite()` (`CURLOPT_SSL_VERIFYPEER = true`, `CURLOPT_SSL_VERIFYHOST = 2`). Previously both checks were disabled, so payment requests could be intercepted by a man-in-the-middle. **What can break:** requests to an endpoint whose certificate is not in the system trust store now throw `TpvException` instead of silently sending data over an unverified connection. Affected environments: Windows PHP without `curl.cainfo`, Alpine/Docker images without `ca-certificates`, TLS-inspecting corporate proxies and local self-signed endpoints. **Fix:** install a CA bundle, or point the library at your CA with `setCaInfo()` / `setCaPath()`. Only as a last resort, `allowInsecureTls()` restores the previous behaviour (see below). See the "TLS y Certificados" section in the README.
- **`check()` validates the notification payload** before indexing it: a non-array payload, missing `Ds_MerchantParameters`/`Ds_Signature`, empty or non-string values, malformed Base64/JSON or a payload without an order now throw `TpvException` instead of returning `false`, indexing undefined keys or emitting PHP warnings. Callers that relied on `check()` returning `false` for a broken payload must catch `TpvException`.
- **`getMerchantParameters()` throws on malformed input** (non-string, empty, invalid Base64 or invalid JSON) instead of returning an incomplete array.

### Security

- Added `Tpv::setCaInfo(?string)` and `Tpv::setCaPath(?string)` to point the library at a custom CA bundle or CA directory while keeping verification mandatory.
- Added an explicit last-resort opt-out, `Tpv::allowInsecureTls(bool)`, which restores the previous behaviour (`VERIFYHOST=0`, `VERIFYPEER=false`). It emits an `E_USER_WARNING`, is documented as not PCI DSS compliant, and must not be used in production or with real card data: `send()` may carry card data through `setPan()`/`setCVV2()`.
- Generated form HTML and JavaScript now escape dynamic values (`createForm()`, `executeRedirection()`, `createInSiteForm()`, `createInSiteFormJSON()`), preventing XSS through configuration values such as the form name, ids and button labels. Output for values without special characters is byte-identical.

### Fixed

- `Tpv::sendInSite()` now stores the generated signature before dispatching the request, so the REST call is actually signed.
- cURL errors are captured before the handle is closed, so the failure message is no longer lost.
- JSON encoding and cURL initialisation failures throw `TpvException` instead of producing a PHP warning.

## Version 1.6.2 (2026-08-22)

### Added

- Added `ANULACION_DE_REFERENCIA = 44` transaction type constant to `MerchantTransactionTypes` for deleting tokenized card references via REST API. Includes PHPDoc with usage example. Thanks to [@alphp](https://github.com/alphp) for the contribution! ([#105](https://github.com/ssheduardo/sermepa/pull/105))
- Updated transaction type documentation table to include code 44.

## Version 1.6.1 (2026-08-22)

### Fixed

- `Tpv::send()` now throws `TpvException` instead of calling `exit()` on REST request failures. This prevents worker process crashes in long-lived PHP runtimes (FrankenPHP, php-fpm) and ensures `curl_close()` is always executed. Thanks to [@HecFranco](https://github.com/HecFranco) for the fix! ([#110](https://github.com/ssheduardo/sermepa/pull/110))

## Version 1.6.0 (2026-03-08)

### Added

- Added InSite integration - embedded payment form via iframe (complete implementation)
- Added new environments: `insiteSandbox`, `insiteLive`, `insiteRestSandbox`, `insiteRestLive`
- Added `createInSiteForm()` method with full parameter support:
  - Container ID customization
  - CSS styles for button, body, box, and inputs
  - Button text (HTML encoded)
  - Language selection (SIS codes and ISO 639-1)
  - Logo visibility toggle
  - Reduced style option
  - InSite style modes: 'inline' or 'twoRows'
- Added `createInSiteFormJSON()` method - JSON-based configuration (recommended)
- Added `sendInSite()` method - executes payment with operation ID
- Added `setInSite()` method - enables/disables InSite mode
- Added `getInSiteMode()` method - gets InSite mode status
- Added `getInSiteJsUrl()` method - gets InSite JavaScript URL
- Added InSite constants in `MerchantEnvironment`:
  - `INSITE_SANDBOX`, `INSITE_LIVE`, `INSITE_REST_SANDBOX`, `INSITE_REST_LIVE`
  - `INSITE_JS_SANDBOX`, `INSITE_JS_LIVE`
- Added `MerchantInsiteLanguage` class - language codes for InSite forms
- Added `MerchantInsiteError` class - error codes and descriptions for InSite validation
- Added `MerchantInsiteStyle` class - style constants (inline, twoRows)
- Added comprehensive InSite documentation with examples

### Changed

- Updated `setEnvironment()` to support InSite environments
- Updated `createInSiteForm()` to require terminal parameter (as per Redsys docs)
- Updated README with complete InSite documentation per official Redsys documentation

### Fixed

- None

## Version 1.5.3 (2026-02-22)

### Added

- Added support for PHP 8.3, 8.4 and 8.5
- Added support for PHPUnit 10

### Changed

- Updated CI workflow to use GitHub Actions with PHP 8.2-8.5
- Improved README with better documentation, tables and examples
- Migrated phpunit.xml.dist to PHPUnit 10 schema
- Updated composer.json with PHP 8.3-8.5 and PHPUnit 10 support

### Fixed

- Fixed test assertions for PHPUnit 10 compatibility
- Removed deprecated ReflectionMethod::setAccessible() call (PHP 8.5 compatibility)
