<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use ReflectionClass;

	class MerchantTransactionTypes {
		public const AUTORIZACION = '0'; // Autorización
		public const PREAUTORIZACION = '1'; // Preautorización
		public const CONFIRMACION_PREAUTORIZACION = '2'; // Confirmación de preautorización
		public const DEVOLUCION_AUTOMATICA = '3'; // Devolución Automática
		public const DEVOLUCION_SIN_ORIGINAL = 'Y'; // Devolución sin original
		public const AUTENTICACION = '7'; // Autenticación
		public const CONFIRMACION_AUTENTICACION = '8'; // Confirmación de Autenticación
		public const ANULACION_AUTORIZACION = '9'; // Anulación de Preautorización o Autorización
		public const ABONO_APUESTAS = '37'; // Abono de Apuestas
		public const PAYGOLD = 'F'; // Paygold

		public static function isValid (string $value) : bool {
			return in_array($value, (new ReflectionClass(self::class))->getConstants());
		}
	}
