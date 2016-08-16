<?php

namespace WireCardSeamlessBundle\Resources\config;
  
/**
 * Contains basic and specific parameter configuration for the setup of the corresponding payment gateway.<br>
 * Used in registration process of a payment extension bundle.
 * @author clic
 *
 */
class ConfigDialogParameters {
	
	/**
	 * Basic parameters, used in every payment gateway of this bundle.
	 * @var Array
	 */
	public static $basicConfigDialogParameters = array(
	
	//TODO: delete test data?
	"customerId" =>  array("value" => "",
			"mandatory" => true,
			"languagekey" => "customerIdKey"),
	
	"secret" => array("value" => "",
			"mandatory" => true,
			"languagekey" => "secretKey"),
	
	"backendOpPassword" => array("value" => "",
			"mandatory" => true,
			"languagekey" => "backendOpPasswordKey"),
	
	"shopId" => array("value" => "",
			"mandatory" => false,
			"languagekey" => "shopIdKey"),
	
	"serviceUrl" => array("value" => "",
			"mandatory" => true,
			"languagekey" => "serviceUrlKey"),
	
	"viewPaymentData" => array("value" => "amount,currency,orderDescription,orderReference,paymentType",
			"mandatory" => true,
			"languagekey" => "viewPaymentDataKey"),
	
	"checkoutMethod" => array("value" => "",
			"mandatory" => false,
			"languagekey" => "checkoutMethodKey"),
	
	"shopHosts" => array("value" => "",
			"mandatory" => false,
			"languagekey" => "shopHostsKey"),
		
// 	"debugMode" => array("value" => "no",
// 			"mandatory" => true,
// 			"languagekey" => "debugModeKey"),
	);
	
	public static function getAllConfigParams($paymentType){
		return array_merge(self::$basicConfigDialogParameters, self::$specificConfigDialogParameters[$paymentType]);
	}
	
	
	/**
	 * Specific parameters, used for the corresponding payment gateway.
	 * @var unknown
	 */
	public static $specificConfigDialogParameters = array(

			"BANCONTACT_MISTERCASH" => array(),
			"CCARD" => array(
				"financialInstitution" => array("value" => "MC,MCSC,Maestro,Visa,VbV,Amex,Diners,Discover,JCB,UATP",
						"mandatory" => true,
						"languagekey" => "financialInstitutionKey"),
				"pciDssSaq" => array("value" => "A-EP",
						"mandatory" => true,
						"languagekey" => "pciDssSaqKey"),
				"ccAdditionalFields" => array("value" => "cardverifycode,cardholdername,issuedate,issuenumber",
						"mandatory" => false,
						"languagekey" => "ccAdditionalFieldsKey"),
				"cssUrl" => array("value" => "",
						"mandatory" => false,
						"languagekey" => "cssUrlKey"),),
			"CCARD-MOTO" => array(
				"financialInstitution" => array("value" => "MC,MCSC,Maestro,Visa,VbV,Amex,Diners,Discover,JCB,UATP",
						"mandatory" => true,
						"languagekey" => "financialInstitutionKey"),
				"pciDssSaq" => array("value" => "A-EP",
						"mandatory" => true,
						"languagekey" => "pciDssSaqKey"),
				"ccAdditionalFields" => array("value" => "cardverifycode,cardholdername,issuedate,issuenumber",
						"mandatory" => false,
						"languagekey" => "ccAdditionalFieldsKey"),
				"cssUrl" => array("value" => "",
						"mandatory" => false,
						"languagekey" => "cssUrlKey"),),
			"EKONTO" => array(),
			"SEPA-DD" => array(),
			"EPS" => array(	
				"financialInstitution1" => array("value" => "BB-Racon,ARZ|BAF,ARZ|BCS,Bawag|B,ARZ|VB,Bawag|E,Spardat|EBS,ARZ|GB,ARZ|HAA",
						"mandatory" => true,
						"languagekey" => "financialInstitution1Key"),
				"financialInstitution2" => array("value" => "ARZ|HI,Hypo-Racon|O,Hypo-Racon|S,Hypo-Racon|ST,ARZ|HTB,ARZ|IB,ARZ|IKB,ARZ|NLH",
						"mandatory" => false,
						"languagekey" => "financialInstitution2Key"),
				"financialInstitution3" => array("value" => "ARZ|OB,ARZ|AB,ARZ|BSS,Bawag|P,Racon,BA-CA,Bawag|S,ARZ|VLH,ARZ|SB,ARZ|SBL",
						"mandatory" => false,
						"languagekey" => "financialInstitution3Key"),
				"financialInstitution4" => array("value" => "ARZ|SBVI,ARZ|VKB,ARZ|BTV,ARZ|BKS,ARZ|AAB,ARZ|BD,ARZ|PB",
						"mandatory" => false,
						"languagekey" => "financialInstitution4Key"),),
			"GIROPAY" => array(),
			"IDL" => array(
				"financialInstitution1" => array("value" => "ABNAMROBANK,ASNBANK,INGBANK,KNAB,RABOBANK",
						"mandatory" => true,
						"languagekey" => "financialInstitution1Key"),
				"financialInstitution2" => array("value" => "SNSBANK,REGIOBANK,TRIODOSBANK,VANLANSCHOT",
						"mandatory" => false,
						"languagekey" => "financialInstitution2Key"),),
			"INSTALLMENT" => array(
				"financialInstitution" => array("value" => "",
						"mandatory" => true,
						"languagekey" => "financialInstitutionKey"),),
			"INVOICE" => array(
				"financialInstitution" => array("value" => "",
						"mandatory" => true,
						"languagekey" => "financialInstitutionKey"),),
			"MONETA" => array(),
			"MPASS" => array(),
			"PRZELEWY24" => array(),
			"PAYPAL" => array(),
			"PBX" => array(),
			"POLI" => array(),
			"PSC" => array(),
			"QUICK" => array(),
			"SKRILLDIRECT" => array(),
			"SKRILLWALLET" => array(),
			"SOFORTUEBERWEISUNG" => array(),
			"TRUSTLY" => array(),
				
				
			// not in wirecard example
			"TATRAPAY" => array(),
			"EPAY_BG" => array(),
			"VOUCHER" => array(),
	);
}
?>
