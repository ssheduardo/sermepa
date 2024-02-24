<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use PHPUnit\Framework\TestCase as PHPUnitTestCase;

	class MerchantPaymethodsTest extends PHPUnitTestCase {
		public function testCodeIsValid () {
			$this->assertTrue(MerchantPaymethods::isValid(MerchantPaymethods::TARJETA));
		}

		public function testCodeNotValid () {
			$this->assertFalse(MerchantPaymethods::isValid('INVALID'));
		}
	}