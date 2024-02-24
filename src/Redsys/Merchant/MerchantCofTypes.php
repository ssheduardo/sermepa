<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use ReflectionClass;

	class MerchantCofTypes {
    public const INSTALLMENTS = 'I';
    public const RECURRING = 'R';
    public const REAUTHORIZATION = 'H';
    public const RESUBMISSION = 'E';
    public const DELAYED = 'D';
    public const INCREMENTAL = 'M';
    public const NO_SHOW = 'N';
    public const OTHER = 'C';

		public static function isValid (string $value) : bool {
			return in_array($value, (new ReflectionClass(self::class))->getConstants());
		}
	}