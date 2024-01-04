<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use PHPUnit\Framework\TestCase as PHPUnitTestCase;

	class MerchantTransactionTypesTest extends PHPUnitTestCase {
		public function testCodeIsValid () {
			$this->assertTrue(MerchantTransactionTypes::isValid(MerchantTransactionTypes::AUTORIZACION));
		}

		public function testCodeNotValid () {
			$this->assertFalse(MerchantTransactionTypes::isValid(-1));
		}
	}