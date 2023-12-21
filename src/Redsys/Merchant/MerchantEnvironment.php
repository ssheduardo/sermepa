<?php
  declare(strict_types=1);

	class MerchantEnvironment {
		public const LIVE = 'live';
		public const TEST = 'test';
		public const REST_LIVE = 'restLive';
		public const REST_TEST = 'restTest';
		public const START_REST_LIVE = 'startRequestRestLive';
		public const START_REST_TEST = 'startRequestRestTest';

		public static function isValid (string $value) : bool {
			return in_array($value, (new ReflectionClass(self::class))->getConstants());
		}
	}