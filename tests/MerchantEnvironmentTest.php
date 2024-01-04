<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use PHPUnit\Framework\TestCase as PHPUnitTestCase;

	class MerchantEnvironmentTest extends PHPUnitTestCase {
		public function testCodeIsValid () {
			$this->assertTrue(MerchantEnvironment::isValid(MerchantEnvironment::LIVE));
		}

		public function testCodeNotValid () {
			$this->assertFalse(MerchantEnvironment::isValid('INVALID'));
		}
	}