<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use PHPUnit\Framework\TestCase as PHPUnitTestCase;

	class MerchantCofTypesTest extends PHPUnitTestCase {
		public function testCodeIsValid () {
			$this->assertTrue(MerchantCofTypes::isValid(MerchantCofTypes::OTHER));
		}

		public function testCodeNotValid () {
			$this->assertFalse(MerchantCofTypes::isValid('INVALID'));
		}
	}