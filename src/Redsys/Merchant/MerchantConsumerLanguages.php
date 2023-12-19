<?php
  declare(strict_types=1);

	namespace Redsys\Merchant;

	use ReflectionClass;

	class MerchantConsumerLanguages {
		public const DEFAULT =   0;	// Por defecto - Español
		public const ES      =   1;	// Español
		public const EN      =   2;	// English - Ingles
		public const CAT     =   3;	// Català
		public const FR      =   4;	// Français - Frances
		public const DE      =   5;	// Deutsch - Aleman
		public const NL      =   6;	// Nederlands - Holandes
		public const IT      =   7;	// Italiano
		public const SV      =   8;	// Svenska - Sueco
		public const PT      =   9;	// Português
 		public const VAL     =  10;	// Valencià
 		public const PL      =  11;	// Polski - Polaco
 		public const GL      =  12;	// Galego
 		public const EU      =  13;	// Euskara
		public const BG      = 100;	// български език - Bulgaro
		public const ZH      = 156;	// Chino
		public const HR      = 191;	// Hrvatski - Croata
		public const CS      = 203;	// Čeština - Checo
		public const DA      = 208;	// Dansk - Danes
		public const ET      = 233;	// Eesti keel - Estonio
		public const FI      = 246;	// Suomi - Finlandes
		public const EL      = 300;	// ελληνικά - Griego
		public const HU      = 348;	// Magyar - Hungaro
		public const JA      = 392;	// Japonés
		public const LV      = 428;	// Latviešu valoda - Leton
		public const LT      = 440;	// Lietuvių kalba - Lituano
		public const MT      = 470;	// Malti - Maltés
		public const RO      = 642;	// Română - Rumano
		public const RU      = 643;	// ру́сский язы́к - Ruso
		public const SK      = 703;	// Slovenský jazyk - Eslovaco
		public const SL      = 705;	// Slovenski jezik - Esloveno
		public const TR      = 792;	// Türkçe - Turco

		public static function isValid (int $value) : bool {
			return in_array($value, (new ReflectionClass(self::class))->getConstants());
		}
	}
