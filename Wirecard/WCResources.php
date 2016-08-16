<?php

namespace WireCardSeamlessBundle\Wirecard;

class WCResources {
	
	/**
	 * <i>paymentTypes</i> represents Wirecard's supported payment types and defines the abbreviations to be used.
	 *
	 */
	public static $paymentTypes = array(
			"BANCONTACT_MISTERCASH" => "Bancontact/Mister Cash",
			"CCARD" => "Credit Card",
			"CCARD-MOTO" => "Credit Card MOTO",
			"EKONTO" => "eKonto",
			"SEPA-DD" => "SEPA Direct Debit",
			"EPS" => "eps Online-Überweisung",
			"GIROPAY" => "giropay",
			"IDL" => "iDEAL",
			"INSTALLMENT" => "Installment",
			"INVOICE" => "Invoice",
			"MONETA" => "moneta.ru",
			"MPASS" => "mpass",
			"PRZELEWY24" => "Przelewy24",
			"PAYPAL" => "PayPal",
			"PBX" => "paybox",
			"POLI" => "POLi",
			"PSC" => "paysafecard",
			"QUICK" => "@Quick",
			"SKRILLDIRECT" => "Skrill Direct",
			"SKRILLWALLET" => "Skrill Digital Wallet",
			"SOFORTUEBERWEISUNG" => "SOFORT Banking",
			"TRUSTLY" => "Trustly",
			"TATRAPAY" => "TatraPay",
			"EPAY_BG" => "ePay.bg",
			"VOUCHER" => "My Voucher",			
			"TRUSTPAY" => "TrustPay",
			
	);

	/**
	 * Maps the Money-Format currency values used in the SAPET system to the ISO 4217 alphabetic values used by Wirecard.
	 *
	 */
	public static $currencyTokens = array(
		"U"  =>  "USD",
		"C"  =>  "CAD",
		"P"  =>  "GBP",
		"X"  =>  "LBP",
		"Z"  =>  "PLN",
		"K"  =>  "DKK",
		"W"  =>  "SEK",
		"H"  =>  "CHF",
		"G"  =>  "LTL",
		"Y"  =>  "CZK",
		"Q"  =>  "HUF",
		"V"  =>  "HRK",
		"B"  =>  "GBN",
		"S"  =>  "RON",
		"F"  =>  "EEK",
		"M"  =>  "LVL",
		"R"  =>  "NOK",
		"I"  =>  "AED",
		"L"  =>  "BHD",
		"E"  =>  "EUR",
	);

	/**
	 * Language tokens used by Wirecard
	 *
	 */
	public static $langTokens = array(
			
		"ar" => "Arabian",
		"bs" => "Bosnian",
		"bg" => "Bulgarian",
		"zh" => "Chinese",
		"hr" => "Croatian",
		"cs" => "Czech",
		"da" => "Danish",
		"nl" => "Dutch",
		"en" => "English",
		"et" => "Estonian",
		"fi" => "Finnish",
		"fr" => "French",
		"de" => "German",
		"el" => "Greek",
		"he" => "Hebrew",
		"hi" => "Hindi",
		"hu" => "Hungarian",
		"it" => "Italian",
		"ja" => "Japanese",
		"ko" => "Korean",
		"lv" => "Latvian",
		"lt" => "Lithuanian",
		"mk" => "Macedonian",
		"no" => "Norwegian",
		"pl" => "Polish",
		"pt" => "Portuguese",
		"ro" => "Romanian",
		"ru" => "Russian",
		"sr" => "Serbian",
		"sk" => "Slovakian",
		"sl" => "Slovenian",
		"es" => "Spanish",
		"sv" => "Swedish",
		"tr" => "Turkish",
		"uk" => "Ukrainian",
	);
	
	/**
	 * Available operations per payment method.<br>
	 * This table presents all supported payment methods and their corresponding toolkit operation(s).<br>
	 * index order: 0: approveReversal, 1: deposit, 2: depositReversal, 3: getOrderDetails, 4: recurPayment, 5: refund, 6: refundReversal, 7: transferFund
	 * @var unknown
	 */
	public static $payMethodToolkitOps = array(
			"BANCONTACT_MISTERCASH" => 	array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"CCARD" => 					array(true, 	true, 	true, 	true, 	false, 	true, 	true, 	false),
			"CCARD-MOTO" => 			array(true, 	true, 	true, 	true, 	false, 	true, 	true, 	false),
			"EKONTO" => 				array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"EPS" => 					array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"EPAY_BG" => 				array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"GIROPAY" => 				array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"IDL" => 					array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"INSTALLMENT" => 			array(true, 	true, 	false, 	true, 	false, 	true, 	false, 	false),			// refund only by payolution
			"INVOICE" => 				array(true, 	true, 	false, 	true, 	false, 	true, 	false, 	false),			// refund only by payolution
			"MONETA" => 				array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"MPASS" => 					array(true, 	true, 	true, 	true, 	false, 	true, 	true, 	false),
			"PBX" => 					array(true, 	true, 	true, 	true, 	false, 	true, 	false, 	false),
			"PAYPAL" => 				array(true, 	true, 	false, 	true, 	false, 	true, 	false, 	false),
			"PSC" => 					array(true, 	true, 	false, 	true, 	false, 	false, 	false, 	false),
			"POLI" => 					array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"PRZELEWY24" => 			array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"QUICK" => 					array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"SEPA-DD" => 				array(true, 	true, 	true, 	true, 	false, 	true, 	true, 	false),			// only within Wirecard Bank
			"SOFORTUEBERWEISUNG" => 	array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),			// RecurPayment for SOFORT Banking will be done as payment method SEPA Direct Debit, i.e. you need to support SEPA to use recurring for SOFORT Banking
			"SKRILLDIRECT" => 			array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"SKRILLWALLET" => 			array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"TATRAPAY" => 				array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"TRUSTLY" => 				array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),
			"VOUCHER" => 				array(false, 	false, 	false, 	true, 	false, 	false, 	false, 	false),			
	);
	
	/**
	 * Array matching paymentTypes to booleans, indicating which of them need a DataStorage for sensible data
	 * @var unknown
	 */
	public static $payMethodNeedingSensibleData = array(
			"BANCONTACT_MISTERCASH" => 	false,
			"CCARD" => 					true,
			"CCARD-MOTO" => 			true,
			"EKONTO" => 				false,
			"EPS" => 					false,
			"EPAY_BG" => 				false,
			"GIROPAY" => 				true,
			"IDL" => 					false,
			"INSTALLMENT" => 			false,
			"INVOICE" => 				false,
			"MONETA" => 				false,
			"MPASS" => 					false,
			"PBX" => 					true,
			"PAYPAL" => 				false,
			"PSC" => 					false,
			"POLI" => 					false,
			"PRZELEWY24" => 			false,
			"QUICK" => 					false,
			"SEPA-DD" => 				true,
			"SOFORTUEBERWEISUNG" => 	false,
			"SKRILLDIRECT" => 			false,
			"SKRILLWALLET" => 			false,
			"TATRAPAY" => 				false,
			"TRUSTLY" => 				false,
			"VOUCHER" => 				true,
	);
	

	/**
	 * Array containing all payment methods that do not allow to embed checkouts in IFrames
	 * @var unknown
	 */
	public static $payMethodIFrameForbidden = array("EPS","PAYPAL","PRZELEWY24","SOFORTUEBERWEISUNG","TRUSTLY","IDL");
	
	
	/**
	 * list of possible financial institutions per payment type. only those with more than 1 possibility listed.
	 * @var array(paymentType => array( financialInstitutionParam => description [, financialInstitutionParam => description])
	 */
	public static $financialInstitutions = array(
			
// 			"BANCONTACT_MISTERCASH" => array("Bancontact/Mister Cash" => "Bancontact/Mister Cash"),
			"CCARD" => array("MC" => "MasterCard",
				"MCSC" => "MasterCard SecureCode",
				"Maestro" => "Maestro SecureCode",
				"Visa" => "Visa",
				"VbV" => "Verified by Visa",
				"Amex" => "American Express",
				"Diners" => "Diners Club",
				"Discover" => "Discover",
				"JCB" => "JCB",
				"UATP" => "Universal Airline Travel Plan"),
			"CCARD-MOTO" => array("MC" => "MasterCard",
					"MCSC" => "MasterCard SecureCode",
					"Maestro" => "Maestro SecureCode",
					"Visa" => "Visa",
					"VbV" => "Verified by VISA",
					"Amex" => "American Express",
					"Diners" => "Diners Club",
					"Discover" => "Discover",
					"JCB" => "JCB",
					"UATP" => "Universal Airline Travel Plan"),
// 			"EKONTO" => array("eKonto" => "eKonto"),
// 			"EPAY_BG" => array("ePay.bg" => "ePay.bg"),
			"EPS" => array("BA-CA" => "Bank Austria",
				"BB-Racon" => "Bank Burgenland",
				"ARZ|BAF" => "Bank für Ärzte und Freie Berufe",
				"ARZ|BCS" => "Bankhaus Carl Spängler & Co. AG",
				"Bawag|B" => "BAWAG",
				"ARZ|VB" => "Die österreichischen Volksbanken",
				"Bawag|E" => "easyBank",
				"Spardat|EBS" => "Erste Bank und Sparkassen",
				"ARZ|GB" => "Gärtnerbank",
				"ARZ|HAA" => "Hypo Alpe-Adria-Bank International AG",
				"ARZ|HI" => "Hypo Investmentbank AG",
				"Hypo-Racon|O" => "Hypo Oberösterreich",
				"Hypo-Racon|S" => "Hypo Salzburg",
				"Hypo-Racon|ST" => "Hypo Steiermark",
				"ARZ|HTB" => "Hypo Tirol Bank AG",
				"ARZ|IB" => "Immo-Bank",
				"ARZ|IKB" => "Investkredit Bank AG",
				"ARZ|NLH" => "Niederösterreichische Landes-Hypothekenbank AG",
				"ARZ|OB" => "Oberbank AG",
				"ARZ|AB" => "Österreichische Apothekerbank",
				"ARZ|BSS" => "Bankhaus Schelhammer & Schattera AG",
				"Bawag|P" => "PSK Bank",
				"Racon" => "Raiffeisen Bank",
				"Bawag|S" => "Sparda Bank",
				"ARZ|VLH" => "Vorarlberger Landes- und Hypothekerbank AG",
				"ARZ|SB" => "Schoellerbank AG",
				"ARZ|SBL" => "Sparda-Bank Linz",
				"ARZ|SBVI" => "Sparda-Bank Villach/Innsbruck",
				"ARZ|VKB" => "Volkskreditbank AG",
				"ARZ|BTV" => "BTV VIER LÄNDER BANK",
				"ARZ|BKS" => "BKS Bank AG",
				"ARZ|AAB" => "Austrian Anadi Bank AG",
				"ARZ|BD" => "bankdirekt.at AG",
				"ARZ|PB" => "PRIVAT BANK AG"),
// 			"GIROPAY" => array("GIROPAY" => "giropay"),
			"IDL" => array("ABNAMROBANK" => "ABN AMRO Bank",
				"ASNBANK" => "ASN Bank",
				"INGBANK" => "ING",
				"KNAB" => "Knab",
				"RABOBANK" => "Rabobank",
				"SNSBANK" => "SNS Bank",
				"REGIOBANK" => "Regio Bank",
				"TRIODOSBANK" => "Triodos Bank",
				"VANLANSCHOT" => "Van Lanschot Bankiers"),
// 			"INVOICE" => array("payolution" => "payolution",
// 				"RatePAY" => "RatePAY"),
// 			"INSTALLMENT" => array("payolution" => "payolution",
// 				"RatePAY" => "RatePAY"),
// 			"MONETA" => array("moneta.ru" => "moneta.ru"),
// 			"MPASS" => array("mpass" => "mpass"),
// 			"PAYPAL" => array("PAYPAL" => "PayPal"),
// 			"PBX" => array("PBX" => "Mobile Phone Invoice"),
// 			"POLI" => array("POLi" => "POLi"),
// 			"PRZELEWY24" => array("Przelewy24" => "Przelewy24"),
// 			"QUICK" => array("QUICK" => "@Quick"),
// 			"SEPA-DD" => array("SEPA-DD" => "SEPA Direct Debit"),
// 			"SKRILLDIRECT" => array("Skrill Direct" => "Skrill Direct"),
// 			"SKRILLWALLET" => array("Skrill Digital Wallet" => "Skrill Digital Wallet"),
// 			"SOFORTUEBERWEISUNG" => array("SOFORTUEBERWEISUNG" => "sofortüberweisung"),
// 			"TATRAPAY" => array("TatraPay" => "TatraPay"),
// 			"TRUSTLY" => array("TRUSTLY" => "Trustly"),
// 			"VOUCHER" => array("ValueMaster" => "Voucher by ValueMaster"),
			
	);
	

	/**
	 * Static URLs to the payment type images
	 * @var array (paymentType => URL)
	 */
	public static $paymentTypeImages = array(			

			"BANCONTACT_MISTERCASH" => "https://static.schwaar.com/logo/wirecard/bancontact_mistercash.png",
			"EKONTO" => "https://static.schwaar.com/logo/wirecard/ekonto.png",
			"SEPA-DD" => "https://static.schwaar.com/logo/wirecard/sepa.png",
			"EPS" => "https://static.schwaar.com/logo/wirecard/eps-online-ueberweisungl.png",
			"GIROPAY" => "https://static.schwaar.com/logo/wirecard/giropay.png",
			"IDL" => "https://static.schwaar.com/logo/wirecard/ideal.png",
			"INVOICE" => "https://static.schwaar.com/logo/wirecard/rechnung_h333.png",
			"INSTALLMENT" => "https://static.schwaar.com/logo/wirecard/ratenzahlung_h333.png",
			"MONETA" => "https://static.schwaar.com/logo/wirecard/moneta_ru.png",
			"MPASS" => "https://static.schwaar.com/logo/wirecard/mpass.png",
			"PRZELEWY24" => "https://static.schwaar.com/logo/wirecard/p24.png",
			"PAYPAL" => "https://static.schwaar.com/logo/wirecard/paypal.png",
			"PBX" => "https://static.schwaar.com/logo/wirecard/paybox.png",
			"POLI" => "https://static.schwaar.com/logo/wirecard/poli.png",
			"PSC" => "https://static.schwaar.com/logo/wirecard/paysafecard_mypaysafecard.png",
			"QUICK" => "https://static.schwaar.com/logo/wirecard/quick.png",
			"SKRILLDIRECT" => "https://static.schwaar.com/logo/wirecard/skrill_direct.png",
			"SKRILLWALLET" => "https://static.schwaar.com/logo/wirecard/skrill_digital_wallet.png",
			"SOFORTUEBERWEISUNG" => "https://static.schwaar.com/logo/wirecard/sofort_ueberweisung.png",
			"TRUSTLY" => "https://static.schwaar.com/logo/wirecard/trustly.png",
			"TATRAPAY" => "https://static.schwaar.com/logo/wirecard/tatrapay.png",
			"EPAY_BG" => "https://static.schwaar.com/logo/wirecard/epay.png",
			"VOUCHER" => "https://static.schwaar.com/logo/wirecard/gutschein_h333.png",
			"TRUSTPAY" => "https://static.schwaar.com/logo/wirecard/trustpay.png",
	);

	/**
	 * Static URLs to the credit card images
	 * @var array (ccType => URL)
	 */
	public static $creditCardImages = array(
			"Visa" => "https://static.schwaar.com/logo/wirecard/visa.png",		
			"VbV" => "https://static.schwaar.com/logo/wirecard/verified_by_visa.png",			
			"MC" => "https://static.schwaar.com/logo/wirecard/mastercard.png",
			"MCSC" => "https://static.schwaar.com/logo/wirecard/secure_code.png",			
			"Diners" => "https://static.schwaar.com/logo/wirecard/dinersclub.png",		
			"Amex" => "https://static.schwaar.com/logo/wirecard/amex.png",	
			"Discover" => "https://static.schwaar.com/logo/wirecard/discover.png",		
			"JCB" => "https://static.schwaar.com/logo/wirecard/jcb.png",				
			"Maestro" => "https://static.schwaar.com/logo/wirecard/maestro_secure_code.png",	
			"UATP" => "https://static.schwaar.com/logo/wirecard/uatpnewlogorgb.png",		
	);
			
	
	
	/**
	 * Returns the appropriate CCard logo for the given financialInstitutions parameter
	 * @param unknown $financialInstitutions
	 * @return array( financialInstitution -> logoURL )
	 */
	public static function getCreditCardImages($financialInstitutions){
		include dirname(__FILE__).'/../Resources/config/config.inc.php';
		$returnValues = array();
		foreach ( $financialInstitutions as $financialInst){			
			if(isset(self::$creditCardImages[$financialInst]))
				$returnValues[$financialInst] = self::$creditCardImages[$financialInst];			
		}
		
		return $returnValues;
	}
	
	/**
	 * Returns the appropriate logo for the given paymentType parameter
	 * @param unknown $financialInstitutions
	 * @return array( financialInstitution -> logoURL )
	 */
	public static function getPaymentTypeImage($paymentType){
		include dirname(__FILE__).'/../Resources/config/config.inc.php';	
				
		if(isset(self::$paymentTypeImages[$paymentType]))
			return self::$paymentTypeImages[$paymentType];
		else return false;
	}
	
	/**
	 * Returns the possible financial institutions for the given payment type
	 * @param string $type payment method
	 * @return array financial institutions if set in $financialInstitutions, false otherwise
	 */
	public static function getFinancialInstitut4PayType($type){
		if(isset(self::$financialInstitutions[$type]))
			return self::$financialInstitutions[$type];	
		else return false;
		
	}
	/**
	 * Check if the given backend operation is available for the given payment method
	 * @param string $type payment method
	 * @param string $op backend operation
	 * @return boolean
	 */
	public static function isToolkitOpAvailable($type, $op){
		$a = array_values(self::$payMethodToolkitOps[$type]);
		return $a[$op];
	}

	/**
	 * Check if sensible data input is needed for the given payment type
	 * @param string $type
	 * @return boolean
	 */
	public static function isSensibleDataNeeded($type){
		return self::$payMethodNeedingSensibleData[$type];
	}
	
	/**
	 * Check if the given payment method allows embedding checkouts in an IFrame
	 * @param string $type
	 * @return boolean
	 */
	public static function isIFrameForbidden($type){
		return in_array($type, self::$payMethodIFrameForbidden);
	}
}