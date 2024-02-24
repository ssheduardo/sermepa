<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use PHPUnit\Framework\TestCase as PHPUnitTestCase;

	class MerchantConsumerLanguagesTest extends PHPUnitTestCase {
		public function testCodeIsValid () {
			$this->assertTrue(MerchantConsumerLanguages::isValid(MerchantConsumerLanguages::ES));
		}

		public function testCodeNotValid () {
			$this->assertFalse(MerchantConsumerLanguages::isValid(-1));
		}
	}