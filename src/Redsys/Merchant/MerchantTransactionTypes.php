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

		/**
		 * Borrar referencia
		 *
		 * Si se desea borrar una referencia creada, se debe enviar el parámetro
		 * Ds_Merchant_Identifier con el valor de la referencia a borrar y el valor
		 * Ds_Merchant_TransactionType con el valor "44":
		 * ```json
		 * {
		 *   "DS_MERCHANT_MERCHANTCODE": "999008881",
		 *   "DS_MERCHANT_IDENTIFIER": "a091f0f9f0aaf0506930dda4a6974f1df4a0d9c1",
		 *   "DS_MERCHANT_ORDER": "0281WjRq",
		 *   "DS_MERCHANT_TERMINAL": "1",
		 *   "DS_MERCHANT_TRANSACTIONTYPE": "44"
		 * }
		 * ```
		 */
		public const ANULACION_DE_REFERENCIA                      = 44; // Anulación de referencia

		public const ANULACION_DE_PAGO                            = 45; // Anulación de pago
		public const ANULACION_DE_DEVOLUCION                      = 46; // Anulación de devolución
		public const ANULACION_DE_CONFIRMACION_SEPARADA           = 47; // Anulación de confirmación separada
		public const MODIFICACION_DE_CADUCIDAD_DEL_ENLACE_PAYGOLD = 51; // Modificación de caducidad del enlace (Paygold)

		public static function isValid (int $value) : bool {
			return in_array($value, (new ReflectionClass(self::class))->getConstants());
		}
	}
