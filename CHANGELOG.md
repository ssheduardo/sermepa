# Changelog

All Notable changes to `Redsys` will be documented in this file

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
