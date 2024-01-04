<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use ReflectionClass;

	class MerchantTransactionTypes {
		public const AUTORIZACION                                 =  0; // Autorización
		public const PREAUTORIZACION                              =  1; // Preautorización
		public const PREAUTORIZACION_DE_REEMPLAZO                 = 11; // Preautorización de reemplazo
		public const CONFIRMACION                                 =  2; // Confirmación de preautorización
		public const DEVOLUCION                                   =  3; // Devolución Automática
		public const PREAUTORIZACION_SEPARADA                     =  7; // Autenticación
		public const CONFIRMACION_SEPARADA                        =  8; // Confirmación de Autenticación
		public const ANULACION                                    =  9; // Anulación de Preautorización o Autorización
		public const PAYGOLD                                      = 15; // Paygold
		public const AUTENTICACION_PUCE                           = 17; // Autenticación Puce
		public const DEVOLUCION_SIN_ORIGINAL                      = 34; // Devolución sin original
		public const PREMIO_DE_APUESTAS                           = 37; // Abono de Apuestas
		public const ANULACION_DE_PAGO                            = 45; // Anulación de pago
		public const ANULACION_DE_DEVOLUCION                      = 46; // Anulación de devolución
		public const ANULACION_DE_CONFIRMACION_SEPARADA           = 47; // Anulación de confirmación separada
		public const MODIFICACION_DE_CADUCIDAD_DEL_ENLACE_PAYGOLD = 51; // Modificación de caducidad del enlace (Paygold)

		public static function isValid (int $value) : bool {
			return in_array($value, (new ReflectionClass(self::class))->getConstants());
		}
	}
