# Changelog

All Notable changes to `Redsys` will be documented in this file

## Version 1.5.2 (2025-03-07)

### Added

- Added a new method to create an order number (createOrderNumber) to generates a Redsys order number following the recommended format.

### Changed

- None

### Fixed

- None

## Version 1.5.1 (2025-01-23)

### Added

- Added a new test to handle successful or error responses from the Redsys payment gateway.
- Updated README with additional information about errorCode verification and the usage of the MIT parameter.

### Changed

- None

### Fixed

- None

## Version 1.5.0 (2025-01-16)

### Added

- None

### Changed

- Updated isEmpty method to properly handle non-string values

### Fixed

- Fixed deprecated warning in isEmpty method when passing null values to trim().
- Fixed incorrect validation of boolean values in isEmpty method

## Version 1.4.9 (2025-01-11)

### Added

- None

### Changed

- None

### Fixed

- I have just fixed an error in the setMerchantCofIni method. It always returns the value 'S'.

## Version 1.4.8 (2024-03-05)

### Added

- Implementation of the `xpay` method within the `setMethod` functionality to support GooglePay and ApplePay.

- TDD (Test Driven Development) implementation for enhanced code reliability and maintainability.

### Changed

- Possible internal changes were made to integrate the `xpay` method and accommodate the TDD implementation, ensuring code consistency.

### Fixed

- None

## Version 1.4.7 (2024-02-24)

### Added

- Static validation methods for convenience and reusability.

- Tests for the new methods and functionalities, ensuring code quality and stability.

### Changed

- Possible internal changes were made to implement the new features.

### Fixed

- None

## Version 1.4.6 (2023-10-28)

### Added

- Test for method getPathJs

- I just added a second optional parameter, $version, was added to the getJsPath() method to allow users to specify the version of the Redsys JavaScript file they want to use. The default version is 2 for compatibility reasons, but users can specify 3 to get the latest Redsys JavaScript file.

### Changed

- None

### Fixed

- None

## Version 1.4.5 (2023-09-26)

### Added

- Tag 1.4.5

### Changed

- Method `check` updated in `Tpv.php` to enhance security and improve validation of signatures. The change involved replacing strict comparison (`===`) with `hash_equals()` for signature validation.

### Fixed

- None

## Version 1.4.4 (2023-08-07)

### Added

- Merge pull request from diegomarty.
- Changed value by default in setMethod: T to C.
- Added validation for this parameters: 'T', 'C', 'R', 'D', 'z', 'p', 'N'
- Added new test for setMethod

### Fixed

- Nothing

## Version 1.4.3 (2023-02-16)

### Added

- Testing with PHP 8.2.
- Added new method getJsPath for inSite.

### Fixed

- Nothing

## Version 1.4.2 (2022-11-10)

### Added

- New environment iniciaPeticionREST to Rest Api.

### Fixed

- Nothing

## Version 1.4.1 (2022-03-07)

### Added

- Nothing

### Fixed

- Updated README, example rest.

## Version 1.4.0 (2022-02-22)

### Added

- Added new method: send using rest.

### Fixed

- setOrder, Allows you to add numbers and letters in the first 4.

## Version 1.3.0 (2020-12-05)

### Added

- Added new method: setParameters

### Deprecated

- Nothing

### Fixed

- Nothing

## Version 1.2.9 (2019-05-18)

### Added

- Added new methods for recurring payment:
  - setSumtotal
  - setChargeExpiryDate
  - setDateFrecuency

### Deprecated

- Nothing

### Fixed

- Nothing

## Version 1.2.8 (2018-10-11)

### Added

- Added travis_ci

### Deprecated

- Nothing

### Fixed

- Fixed errors when uses php5.6 (travis_ci)

## Version 1.2.7 (2018-09-03)

### Added

- Added test.
- Added method getNameForm.

### Deprecated

- Nothing

### Fixed

- Changed property and methods private to protected

## Version 1.2.6 (2018-08-02)

### Added

- Add support to chain methods

### Deprecated

- Nothing

### Fixed

- Nothing

## Version 1.2.5 (2018-04-04)

### Added

- Nothing

### Deprecated

- Nothing

### Fixed

- Changed validation for setCurrency, not limit to 978, 840, 826, 392

## Version 1.2.4.1 (2018-03-22)

### Added

- Nothing

### Deprecated

- Nothing

### Fixed

- Changed information text about of parameter by default for setMethod.

## Version 1.2.4 (2017-12-11)

### Added

- Merge pull request (Minor cosmetic fixes).
- Added setEnvironment.

### Deprecated

- Method setEnviroment.

### Fixed

- Nothing

## Version 1.2.3 (2017-11-23)

### Added

- Throwing custom exceptions TpvException

### Deprecated

- Nothing

### Fixed

- Nothing

## Version 1.2.2 (2017-06-14)

### Added

- Method setPan, Set card number.
- Method setExpiryDate, Set expiry date of card number.
- Method setCVV2, Set CVV2 of card number.

### Deprecated

- Nothing

### Fixed

- Nothing

## Version 1.2.1 (2017-05-20)

### Added

- Nothing

### Deprecated

- Nothing

### Fixed

- The method setOrder, now verified that the first 4 digits must be numeric and maximum 12 characters.

## Version 1.2 (2017-01-27)

### Added

- Nothing

### Deprecated

- Nothing

### Fixed

- Changed the function mcrypt_encrypt to openssl_encrypt, with the new updated of PHP 7.1 the function mcrypt_encrypt is deprecated.

## Version 1.1.6 (2016-10-19)

### Added

- Method setIdentifier, This parameter is used to handle the associated reference data card. It is an alphanumeric field of up to 40 positions whose value is generated by the Virtual TPV.
- Method setMerchantDirectPayment, This parameter is optional, functions as a flag indicating whether to display additional screens (DCC, Fractionation and Authentication) default values are "true" or "false". If you used with the value "true", not additional screens (DCC, Fractionation and Authentication) are displayed during payment and should be used in conjunction with the parameter Ds_Merchant_Identifier containing a valid reference.

### Deprecated

- Nothing

### Fixed

- setAmount, Now amount maybe 0, it is for uses setIdentifier.

## Version 1.1.5 (2016-06-17)

### Added

- Method getVersion, return version example: HMAC_SHA256_V1
- Method getMerchantSignature, return merchant signature example: Cia90trhTPGxtJDmK6WDhqXzU+98LbuKZKAKYHMjtMs=

### Deprecated

- Nothing

### Fixed

- Nothing
