<?php

namespace WireCardSeamlessBundle\Wirecard;

use WireCardSeamlessBundle\Resources\MyLog;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\SystemInfo;
use WireCardSeamlessBundle\Resources\MyUtils;
use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException;
use WireCardSeamlessBundle\Resources\Languages\LanguageManager;

/**
 * 'Wirecard Checkout Toolkit light' provided by Wirecard
 * @author schwaar GmbH, Wirecard CEE
 */
class WCDataStorage {


	/**
	 * URLs for accessing the Wirecard Checkout Platform
	 * @var string
	 */
	public static $URL_DATASTORAGE_INIT = "https://checkout.wirecard.com/seamless/dataStorage/init";
	public static $URL_DATASTORAGE_READ = "https://checkout.wirecard.com/seamless/dataStorage/read";
	public static $URL_FRONTEND_INIT = "https://checkout.wirecard.com/seamless/frontend/init";
	
	private static $PCI3_DSS_SAQ_A_CCARD_SHOW_CVC;
	private static $PCI3_DSS_SAQ_A_CCARD_SHOW_ISSUEDATE;
	private static $PCI3_DSS_SAQ_A_CCARD_SHOW_ISSUENUMBER;
	private static $PCI3_DSS_SAQ_A_CCARD_SHOW_CARDHOLDERNAME;
	
	// SAPET objects
	private $log;
	private $transaction;
	private $systemInfo;
	
	/**********************Required Parameters*************************/
	
	/**
	 * Unique ID of merchant.
	 * @var string Alphanumeric with a fixed length of 7.
	 */
	private $customerId;		
	
	
	/**
	 * Unique reference to the order of your consumer.
	 * @var string Alphanumeric
	 */
	private $orderIdent;		
	
	
	/**
	 * Return URL for outdated browsers.
	 * @var string Alphanumeric
	 */
	private $returnUrl;		
	
	
	/**
	 * Language for returned texts and error messages.
	 * @var string Alphabetic with a fixed length of 2.
	 */
	private $language;		
	
	
	/**
	 * Computed fingerprint of the parameter values and the secret.
	 * @var string Alphanumeric with a fixed length of 128.
	 */
	private $requestFingerprint;		


	/**********************Optional Parameters*************************/
	
	/**
	 * Unique ID of your online shop.
	 * @var string Alphanumeric with a variable length of 16.
	 */
	private $shopId;		
	
	/**
	 * Version number of JavaScript.
	 * @var string Alphanumeric
	 */
	private $javascriptScriptVersion;
	
	
	public function initDataStorage($configurationParameters, DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer, SystemInfo $system, LoggerInterface $log){

		$this->transaction = &$transaction;
		$this->systemInfo = $system;
		$this->log = $log;
		
		$ccAdditionalFieldsTrimmed = preg_replace('/\s+/', '', $configurationParameters["ccAdditionalFields"]);
		$ccAdditionalFields = explode(",", $ccAdditionalFieldsTrimmed);
		
		$this->PCI3_DSS_SAQ_A_CCARD_SHOW_CVC = in_array("cardverifycode", $ccAdditionalFields) ? true : false;
// 		$this->PCI3_DSS_SAQ_A_CCARD_SHOW_ISSUEDATE = in_array("showIssueDate", $ccAdditionalFields) ? true : false;
// 		$this->PCI3_DSS_SAQ_A_CCARD_SHOW_ISSUENUMBER = in_array("showIssueNumber", $ccAdditionalFields) ? true : false;
		$this->PCI3_DSS_SAQ_A_CCARD_SHOW_CARDHOLDERNAME = in_array("cardholdername", $ccAdditionalFields) ? true : false;
		
		$this->customerId = $configurationParameters["customerId"];
		$this->orderIdent = $transaction->tid;
		$this->returnUrl = $dialogData->cancelURL;
		$this->language = $system->languageCode;
		$this->shopId = $configurationParameters["shopId"];
		$this->javascriptScriptVersion = '';
		
		// calculate fingerprint to verify request
		$this->requestFingerprint = $this->calculateFingerprint($configurationParameters);
		
		// create POST request and send to Wirecard
		$curlResult = $this->createAndSendPOST($configurationParameters);	
		
		MyLog::log("dataStorage curlResult: ".print_r($curlResult,true),$this->transaction, "debug");
		MyUtils::storeGatewayData($transaction, $this->transaction->gatewayData,"dataStorageResponse",$curlResult);
			
		$javascriptUrl = $this->retrieveData($curlResult);		
		
		if($javascriptUrl != "") 
			MyLog::log("DataStorage initiated and javascriptUrl received successfully.", $transaction, "info", null, $this->log);
		else
			MyLog::log("No javascriptUrl received!", $transaction, "error", null, $this->log);
		
		return $javascriptUrl;
	}
	
	/**
	 * Computes the fingerprint based on the request parameters used for the
	 * initiation of the Wirecard data storage.
	 * @param array $configurationParameters
	 * @return string
	 */
	private function calculateFingerprint($configurationParameters){

		
		// initializes the fingerprint seed
		// please be aware that the correct order for the fingerprint seed has
		// to be the following one:
		// customerId, shopId, orderIdent, returnUrl, language, javascriptScriptVersion, secret
		$requestFingerprintSeed  = "";
		
		// adds the customer id to the fingerprint seed
		$requestFingerprintSeed  .= $this->customerId;
		
		// adds the shop id to the fingerprint seed
		$requestFingerprintSeed  .= $this->shopId;
		
		// adds the unique identification for the order (order identity) to the fingerprint seed
		
		$_SESSION["orderIdent"] = $this->orderIdent;
		$requestFingerprintSeed  .=  $this->orderIdent;
		
		$requestFingerprintSeed  .= $this->returnUrl;
		
		// adds the language to the fingerprint seed
		$requestFingerprintSeed  .= $this->language;
		
		// adds the JavaScript version to the fingerprint seed
		if(isset($GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"]))
			if($GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] == "A"){
				$this->javascriptScriptVersion =  "pci3";
				$requestFingerprintSeed  .= $this->javascriptScriptVersion;
			}
		
		// adds the merchant specific secret to the fingerprint seed
		$requestFingerprintSeed  .= $configurationParameters["secret"];
		
		MyLog::log("fingerprintSeed: ".print_r($requestFingerprintSeed,true),$this->transaction, "verbose");
		
		// computes the fingerprint based on SHA512 and the fingerprint seed
		return hash_hmac("sha512", $requestFingerprintSeed, $configurationParameters["secret"]);
		
	}
	
	/**
	 * Creates and sends a POST request (server-to-server request) to the
	 * Wirecard Checkout Platform for initiating the Wirecard data storage.
	 * @return mixed
	 */
	private function createAndSendPOST($configurationParameters){

		// initiates the string containing all POST parameters and
		// adds them as key-value pairs to the post fields
		$postFields = "";
		$postFields .= "customerId=" . $this->customerId;
		$postFields .= "&shopId=" . $this->shopId;
		$postFields .= "&orderIdent=" . $this->orderIdent;
		$postFields .= "&returnUrl=" . $this->returnUrl;
		$postFields .= "&language=" . $this->language;
		if($this->javascriptScriptVersion != "") $postFields .= "&javascriptScriptVersion=" . $this->javascriptScriptVersion;
		
		if (isset($GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"]) && $GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] == "A")
		{
			if (isset($configurationParameters["cssUrl"]))
				$postFields .= '&iframeCssUrl=' . $configurationParameters["cssUrl"];
		
			if ($this->PCI3_DSS_SAQ_A_CCARD_SHOW_CVC !== null)
				$postFields .= '&creditcardShowCvcField=' . ($this->PCI3_DSS_SAQ_A_CCARD_SHOW_CVC ? 'true' : 'false');
		
// 			if ($this->PCI3_DSS_SAQ_A_CCARD_SHOW_ISSUEDATE !== null)
// 				$postFields .= '&creditcardShowIssueDateField=' . ($this->PCI3_DSS_SAQ_A_CCARD_SHOW_ISSUEDATE ? 'true' : 'false');
		
// 			if ($this->PCI3_DSS_SAQ_A_CCARD_SHOW_ISSUENUMBER !== null)
// 				$postFields .= '&creditcardShowIssueNumberField=' . ($this->PCI3_DSS_SAQ_A_CCARD_SHOW_ISSUENUMBER ? 'true' : 'false');
		
			if ($this->PCI3_DSS_SAQ_A_CCARD_SHOW_CARDHOLDERNAME !== null)
				$postFields .= '&creditcardShowCardholderNameField=' . ($this->PCI3_DSS_SAQ_A_CCARD_SHOW_CARDHOLDERNAME ? 'true' : 'false');
		}

		$postFields .= "&requestFingerprint=" . $this->requestFingerprint;

		MyLog::log("dataStorage-init postfields: ".print_r($postFields,true),$this->transaction, "debug");

		MyUtils::storeGatewayData($this->transaction, $this->transaction->gatewayData, "dataStorageRequest", $postFields);
		
		// initializes the libcurl of PHP used for sending a POST request
		// to the Wirecard data storage as a server-to-server request
		
		$curl = curl_init();
		
		// sets the required options for the POST request via curl
		curl_setopt($curl, CURLOPT_URL, self::$URL_DATASTORAGE_INIT);
		curl_setopt($curl, CURLOPT_PROXY, $this->systemInfo->httpProxy.":". $this->systemInfo->httpProxyPort);
		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		
		// sends a POST request to the Wirecard Checkout Platform and stores the
		// result returned from the Wirecard data storage in a string for later use
		$curlResult = curl_exec($curl);

		if(curl_error($curl) != ""){
			MyLog::log("Initiating DataStorage failed: ".curl_error($curl),$this->transaction, "debug", null, $this->log);
			throw new PaymentException( LanguageManager::getLanguageEntry ( $this->system->languageCode, "wirecard.datastorage.init.failed" ) );
		}
		
		// closes the connection to the Wirecard Checkout Platform
		curl_close($curl);
		
		return $curlResult;
	}
	
	/**
	 * Retrieves the storage id and the JavaScript URL returned from the
	 * initiation of the Wirecard data storage by the previous POST request.
	 * @param mixed $curlResult
	 * @return string $javascriptURL
	 */
	private function retrieveData($curlResult){
		
		// initiates the storage id and javascript URL
		$storageId = "";
		$javascriptURL = "";
		
		// extracts each key-value pair returned from the previous POST request
		foreach (explode('&', $curlResult) as $keyvalue) {
			// splits the key and the name of each key-value pair
			$param = explode('=', $keyvalue);
			if (count($param) == 2) {
				// decodes key and value
				$key = urldecode($param[0]);
				$value = urldecode($param[1]);
				if (strcmp($key, "storageId") == 0) {
					$storageId = $value;
					// saves the storage id in a session variable for later use
					// when reading data from the data storage in file read.php
					$_SESSION['wc_storage_id'] = $storageId;
					MyLog::log("retrieved storageId: ".$key."=>".$value,$this->transaction, "verbose");
				}
				if (strcmp($key, "javascriptUrl") == 0) {
					// saves the JavaScript URL in variable for later use within this file
					$javascriptURL = $value;
					MyLog::log("retrieved javascriptURL: ".$key."=>".$value,$this->transaction, "verbose");
				}
			}
		}

		return $javascriptURL;
	}
	
	
	
	
	/********** Getters & Setters *************/
	
	public function getCustomerId() {
		return $this->customerId;
	}
	public function setCustomerId($customerId) {
		$this->customerId = $customerId;
		return $this;
	}
	public function getOrderIdent() {
		return $this->orderIdent;
	}
	public function setOrderIdent($orderIdent) {
		$this->orderIdent = $orderIdent;
		return $this;
	}
	public function getReturnUrl() {
		return $this->returnUrl;
	}
	public function setReturnUrl($returnUrl) {
		$this->returnUrl = $returnUrl;
		return $this;
	}
	public function getLanguage() {
		return $this->language;
	}
	public function setLanguage($language) {
		$this->language = $language;
		return $this;
	}
	public function getRequestFingerprint() {
		return $this->requestFingerprint;
	}
	public function setRequestFingerprint($requestFingerprint) {
		$this->requestFingerprint = $requestFingerprint;
		return $this;
	}
	public function getShopId() {
		return $this->shopId;
	}
	public function setShopId($shopId) {
		$this->shopId = $shopId;
		return $this;
	}
	public function getJavascriptScriptVersion() {
		return $this->javascriptScriptVersion;
	}
	public function setJavascriptScriptVersion($javascriptScriptVersion) {
		$this->javascriptScriptVersion = $javascriptScriptVersion;
		return $this;
	}
			 
	
	
	
	
	
}