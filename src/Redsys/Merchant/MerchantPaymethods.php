<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use ReflectionClass;

	class MerchantPaymethods {
		public const ALL = '';
		public const TARJETA = 'C';
		public const TARJETA_IUPAY = 'T';
		public const BIZUM = 'z';
		public const PAYPAL = 'P';
		public const TRANSFERENCIA = 'R';
		public const MASTERPASS = 'N';
		public const IUPAY = 'O';

		public static function isValid (string $value) : bool {
			return in_array($value, (new ReflectionClass(self::class))->getConstants());
		}
	}
