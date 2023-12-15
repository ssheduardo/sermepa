<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use PHPUnit\Framework\TestCase as PHPUnitTestCase;

	class MerchantCurrenciesTest extends PHPUnitTestCase {
		public function testCodeIsValid () {
			$this->assertTrue(MerchantCurrencies::isValid(MerchantCurrencies::EUR));
		}

		public function testCodeNotValid () {
			$this->assertFalse(MerchantCurrencies::isValid('INVALID'));
		}
	}