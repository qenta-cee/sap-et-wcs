<?php
	
namespace WireCardSeamlessBundle\Wirecard\Request;


use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use SAP\EventTicketing\DataExchangeObject\User;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Resources\MyLog;
use SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\SystemInfo;
use WireCardSeamlessBundle\Resources\MyUtils;


/**
 * Basic abstract class for payment request objects, being extended by the payment-type-specific subclasses
 * @author clic
 *
 */
abstract class WCBasicPaymentRequest {
	
	/**
	 * Sets the payment-type-specific parameters of the payment request object.
	 * @param DialogData $dialogData
	 * @param PaymentTransaction $transaction
	 * @param Company $company
	 * @param Customer $customer
	 */
	abstract public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer);
		
	
	/***************************************	REQUIRED PARAMETERS		***************************************/
	// 	used within Wirecard Checkout Page and Wirecard Checkout Seamless
	//  If one or more of these required parameters are missing you will get an error message from the Wirecard Checkout	

	
	/**
	 * Unique ID of merchant.
	 * Within fingerprint: Required
	 * @var string Alphanumeric with a fixed length of 7
	 */
	protected $customerId;	

	/**
	 * Personal secret sent by Wirecard together with customerId.
	 * Within fingerprint: Required
	 * @var string
	 */
	protected $secret;
	
	/**
	 * Language for displayed texts on payment page.
	 * Within fingerprint: Required
	 * @var string Alphabetic with a fixed length of 2
	 */
	protected $language;
	
	/** 
	 * Selected payment method of your consumer.
	 * Within fingerprint: Optional		
	 * @var Enumeration										
	 *	
	 */
	protected $paymentType;
			
	/**	
	 * Amount of payment.
	 * Within fingerprint: Required
	 * @var float
	 */
	protected $amount;			
	
	/**
	 * Currency code of amount.
	 * Within fingerprint: Required
	 * @var string	Alphabetic with fixed length of 3 or numeric 3
	 */
	protected $currency;
	
	/**
	 * Unique description of the consumer's order in a human readable form.
	 * Within fingerprint: Required
	 * @var string  Alphanumeric with a variable length of up to 255
	 */
	protected $orderDescription ;
	
	/**
	 * URL of your online shop when checkout process was successful.
	 * Within fingerprint: Required
	 * @var string	Alphanumeric with special characters
	 */	
	protected $successUrl;
		
	/**
	 * URL of your online shop when checkout process has been cancelled.
	 * Within fingerprint: Optional
	 * @var string	Alphanumeric with special characters
	 */
	protected $cancelUrl;
			
	/**
	 * URL of your online shop when an error occured within checkout process.
	 * Within fingerprint: Optional
	 * @var string	Alphanumeric with special characters
	 */
	protected $failureUrl;
	
	/**
	 * URL of your service page containing contact information.
	 * Within fingerprint: Optional
	 * @var string Alphanumeric with special chars, variable length up to 255
	 */
	protected $serviceUrl;
	
	/**
	 * Ordered list of parameters used for calculating the fingerprint.
	 * Within fingerprint: Required
	 * @var string Alphanumeric with special characters
	 */
	protected $requestFingerprintOrder;
	
	/**
	 * Computed fingerprint of the parameter values as given in the requestFingerprintOrder.
	 * Within fingerprint: Never
	 * @var string Alphanumeric with a fixed length of 32
	 */
	protected $requestFingerprint;
	
	/**
	 * Version of payment gateway
	 * Within fingerprint: Optional
	 * @var string Alphanumeric with special characters
	 */
	protected $pluginVersion;
	
	/***************************************	REQUIRED PARAMETERS		***************************************/
	//	additionally used within Wirecard Checkout Seamless	
	
	/**
	 * IP address of consumer
	 * Within fingerprint: Required
	 * @var string Numeric with special characters
	 */
	protected $consumerIpAddress;
	
	/**
	 * User-agent of browser of consumer
	 * Within fingerprint: Required
	 * @var string Alphanumeric with special characters
	 */
	protected $consumerUserAgent;
	
	
	
	
	/***************************************	OPTIONAL PARAMETERS		***************************************/
	//	used within Wirecard Checkout Page and Wirecard Checkout Seamless
	
	/**
	 * Based on pre-selected payment method a sub-selection of financial institutions regarding to pre-selected payment method.
	 * Within fingerprint: Optional
	 * @var Enumeration
	 */
	protected $financialInstitution;
	
	/**
	 * URL of your online shop when result of checkout process could not be determined yet.
	 * Within fingerprint: Optional
	 * @var string Alphanumeric with special characters
	 */
	protected $pendingUrl;	
	
	/**
	 * URL of your online shop where Wirecard sends a server-to-server confirmation.
	 * Within fingerprint: Required if used (Required for WCSeamless)
	 * @var string Alphanumeric with special characters
	 */
	protected $confirmUrl;
	
	/**
	 * URL of your online shop where your information page regarding de-activated Javascript resides.
	 * Within fingerprint: Optional
	 * @var string Alphanumeric with special characters
	 */
	protected $noScriptInfoUrl;
	
	/**
	 * Order number of payment.
	 * Within fingerprint: Required if used
	 * @var int Numeric with a variable length of up to 9
	 */
	protected $orderNumber;
	
	/**
	 * Window name of browser, window where payment page is opened.
	 * Within fingerprint: Optional
	 * @var string
	 */
	protected $windowName;
	
	/**
	 * Check for duplicate requests done by your consumer.
	 * Within fingerprint: Required if used
	 * @var string (“yes” or “no”)
	 */
	protected $duplicateRequestCheck;		
	
	/**
	 * Text displayed on invoice of financial institution of your consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with up to 254 characters, but may differ for specific payment methods
	 */
	protected $customerStatement;
	
	/**
	 * Unique order reference ID sent from merchant to financial institution.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with up to 128 characters, but may differ for specific payment methods
	 */
	protected $orderReference;
	
	/**
	 * Possible values are SINGLE (for one-off transactions) or INITIAL (for the first transaction of a series of recurring transactions).
	 * Within fingerprint: Required if used
	 * @var Enumeration
	 */
	protected $transactionIdentifier;
	
	

	/**
	 * Enable automated debiting of payments.
	 * Within fingerprint: Required if used.
	 * @var string ”yes” or ”no”.
	 */
	protected $autoDeposit;
	
	/**
	 * One payment confirmation mail address for the merchant.
	 * Within fingerprint: Required if used.
	 * @var string	Alphanumeric with special characters and a variable length of up to 127.
	 */
	protected $confirmMail;
	
	/**
	 * Unique ID of your online shop within your customer ID to enable various configurations of your online shop.
	 * Within fingerprint: Required if used.
	 * @var string	Alphanumeric with a fixed length of 16.
	 */
	protected $shopId;
	
	
	
	
	/***************************************	OPTIONAL PARAMETERS		***************************************/
	//	used within Wirecard Checkout Seamless
	
	/**
	 * Unique ID of order which has to be the same as used for initiating the data storage
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with special characters
	 */
	protected $orderIdent;
	
	/**
	 * Unique ID of data storage for a specific consumer
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a fixed length of 32
	 */
	protected $storageId;
	
	//	Consumer billing data -------------> parameters are in the appropriate subclasses
	// 	Consumer shipping data -------------> parameters are in the appropriate subclasses	
	
	

	/***************************************	SHOPPING BASKET DATA		***************************************/
	// used in some specific payment types (e.g. PayPal)
	
	
	/**
	 * Overall amount of shopping cart.
	 * Within fingerprint: Required if used.
	 * @var float	Amount
	 */
	protected $basketAmount;
	
	/**
	 * Code of currency based on ISO 4217.
	 * Within fingerprint: Required if used.
	 * @var string Alphabetic with a fixed length of 3 or numeric with a fixed length of 3.
	 */
	protected $basketCurrency;
	
	/**
	 * Number of items in shopping cart.
	 * Within fingerprint: Required if used.
	 * @var int	Numeric
	 */
	protected $basketItems;
	
	/**
	 * List of BasketItem objects.
	 * @var Array
	 */
	protected $basketItemList;	
	
	/**
	 * Returns an array of all visible attributes of this object and its values (with value not null).
	 * The <i>secret</i> parameter is excluded, because it must not be sent in the wirecard POST request.
	 * The resulting array is sorted in ascending order.
	 * @return array("varName" => varValue, ..) in ascending order
	 */
	public function collectParameters(){
		$allParams = get_object_vars($this);
		
		// Set the 'secret' parameter to null
		$allParams["secret"] = null;
		
		//remove all null properties and sort alphabetically
		$filteredArray = array_filter($allParams);
		ksort($filteredArray);
		
		return $filteredArray;
	}
	

	/**
	 * Maps the <i>$params</i> array into the object's properties. The key value of each array entry is assumed to match a property name.
	 * @param array $params
	 * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	public function setParameters($params){
				
		// remove non-basic request parameters
		unset($params["backendOpPassword"]);
		unset($params["viewPaymentData"]);
		unset($params["debugDir"]);
		unset($params["debugMode"]);
		unset($params["pciDssSaq"]);
		unset($params["cssUrl"]);
		unset($params["ccAdditionalFields"]);
		unset($params["checkoutMethod"]);
		unset($params["shopHosts"]);
		
		unset($params["cashing_email"]);
		
		unset($params["financialInstitution"]);
		unset($params["financialInstitution1"]);
		unset($params["financialInstitution2"]);
		unset($params["financialInstitution3"]);
		unset($params["financialInstitution4"]);

		// for all other params set the appropraite field
		foreach($params as $key=>$value)
			if(property_exists($this, $key))
				$this->$key = $value;
			else{
				throw new PaymentException("WCBasicPaymentRequest->setParameters: Property '".$key."' does not exist!");

			}
	}
	
	/**
	 * Setup the payment request object by setting all its basic and payment-type-specific parameters.
	 * @param array $configParams
	 * @param DialogData $dialogData
	 * @param PaymentTransaction $transaction
	 * @param Company $company
	 * @param Customer $customer
	 */
	public function setupRequestParameters($configParams, DialogData $dialogData, PaymentTransaction $transaction, Company $company=NULL, Customer $customer=NULL, SystemInfo $system){
		
		$this->setupBasicParameters($configParams, $dialogData, $transaction, $company, $customer, $system);
		
		$this->setupSpecificParameters($dialogData, $transaction, $company, $customer);
		
	}
	
	/**
	 * Sets the basic (non-specific) parameters of the payment request object.
	 * @param array $configParams
	 * @param DialogData $dialogData
	 * @param PaymentTransaction $transaction
	 * @param Company $company
	 * @param Customer $customer
	 * 
	 * @throws SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	private function setupBasicParameters($configParams, DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer, SystemInfo $system){
		
		// build order description string		
		$orderDescString = "";
		if($customer != NULL){
			if(isset($customer->firstName) && !empty($customer->firstName))
				$orderDescString .= $customer->firstName." ";
			if(isset($customer->lastName) && !empty($customer->lastName))
				$orderDescString .= $customer->lastName." ";
			if(isset($customer->number) && !empty($customer->number) )
				$orderDescString .= "(".$customer->number.") ";
			if((isset($customer->firstName) && !empty($customer->firstName)) || (isset($customer->lastName) && !empty($customer->lastName)) || (isset($customer->number) && !empty($customer->number) ) )
				$orderDescString .= ": ";
		}
		$orderDescString.="TID ".$transaction->tid;		
		
		$this->setOrderDescription($orderDescString);
		
		// since SAPET 6.1 notifyUrl is used for comfirmation
		$this->setConfirmUrl(urldecode($dialogData->notifyURL));

		
		// for full-page-overlay in onlineshops the URLs from dialogData are used (to trigger call of redirectUrl in browser)
		$checkoutMethod = MyUtils::detectCheckoutMethod($configParams["checkoutMethod"], $this->paymentType, $system );
		if($checkoutMethod == "redirect"){

// 			$this->setCancelUrl(urldecode($dialogData->cancelURL));
// 			$this->setSuccessUrl(urldecode($dialogData->successURL));
// 			$this->setFailureUrl(urldecode($dialogData->cancelURL));	
				
			$sapetHostArray = parse_url(urldecode($dialogData->successURL));
			$sapetHost = $sapetHostArray["host"]."/online";
			$shopHost = $sapetHost;
				
			// if onlineshop, check for reverse proxy settings
			try{
				if(isset($configParams["shopHosts"]) && $configParams["shopHosts"] != ""){
					$shopHostsTrimmed = preg_replace('/\s+/', '', $configParams["shopHosts"]);
					$shopHosts = explode(",", $shopHostsTrimmed);
			
					foreach($shopHosts as $key=>$value){
						$shopIdAndHost = explode(":", $value );
						if(strval($system->onlineshop) == $shopIdAndHost[0]){
							if(strpos($shopIdAndHost[1],"/") !== false){
								$shopHost = $shopIdAndHost[1];								
							}else
								$shopHost = $shopIdAndHost[1]."/online";
							break;
						}
					}
				}
			}catch (\Exception $e){
				throw new PaymentException("Error when trying to parse the shop hosts settings!");
			}
				
			// set redirect URL to enable a redirect in shops  
			// if shop hosts for reverse proxy settings found, replace the host string while building redirectUrl
			if($shopHost != $sapetHost){
				// remove slash at the end
				if(substr($shopHost, strlen($shopHost)-1, strlen($shopHost)-1) == "/")
					$shopHost = substr($shopHost, 0, strlen($shopHost)-1);
				$redirectUrl = str_replace($sapetHost, $shopHost, $dialogData->url) . '&nextstate=9&ccbutton=1&agb=y&datastorage=y';
// 				$transaction->gatewayData["redirectTo"] = $redirectUrl;		// this would enable the call of reservePaymentData() and finalize() after processNotify() without a necessary redirect happening in the browser
				$this->setCancelUrl($redirectUrl);
				$this->setSuccessUrl($redirectUrl);
				$this->setFailureUrl($redirectUrl);
			}else{
				$redirectUrl = $dialogData->url . '&nextstate=9&ccbutton=1&agb=y&datastorage=y';
// 				$transaction->gatewayData["redirectTo"] = $dialogData->url . '&nextstate=9&ccbutton=1&agb=y&datastorage=y';
				$this->setCancelUrl($redirectUrl);
				$this->setSuccessUrl($redirectUrl);
				$this->setFailureUrl($redirectUrl);
			}
				
		// for iframe and popup version, a dummy URL is used for cancel/success/.. URLs. 
		// (For information about which paytype supports which checkout method, see the installation manual.)
		}else{
			$decodedSuccessUrl = urldecode($dialogData->successURL);
			$explodedUrl = explode("/", $decodedSuccessUrl);
			$sessionId = $explodedUrl[count($explodedUrl) -3];
			$pos = strpos($decodedSuccessUrl, "PaymentData");
			$cutUrl = substr($decodedSuccessUrl, 0, $pos+11)."/".$sessionId."/EMPTY/notify";
			
			$this->setCancelUrl($cutUrl);
			$this->setSuccessUrl($cutUrl);
			$this->setFailureUrl($cutUrl); 		
		}
		
		$this->setOrderIdent($transaction->tid);
		$this->setOrderReference($transaction->tid);
		$this->setOrderNumber($transaction->tid);	// set orderNumber manually
		
		// parse currency and amount
		$val = trim($transaction->value);
		$currency = substr($val,-1);
		$amount = substr($val,0,strlen($val)-1);
		
		if(($amount != false && $amount != "") && ($currency != false && $currency != "")){
			$this->setAmount($amount);		
			$this->setCurrency(WCResources::$currencyTokens[$currency]);	
		}else
			throw new PaymentException("Error when trying to parse amount and currency!");
		
		$this->setConsumerUserAgent($_SERVER['HTTP_USER_AGENT']);
		$this->setConsumerIpAddress($_SERVER['REMOTE_ADDR']);
		

		// if the storageId was set in the collect call before, take it
		$this->setStorageId($_SESSION['wc_storage_id']);
		
		//DONE: fill basketItemList with WCBasketItem objects (if necessary) -> update: no basket item info from SAPET!
		
// 		if(isset($this->basketItemList)){
// 			$this->basketItems = count($this->basketItemList);
// 		}

		// set plugin version parameter
		if($system->onlineshop != 0)
			$this->setPluginVersion(base64_encode("Online Shop ".$system->onlineshop. ';' . "" . ';' . "" . ';' . 'WirecardSeamlessBundle' . ';' . '1.1.0'));
		else
			$this->setPluginVersion(base64_encode("SAPET Backend" . ';' . "" . ';' . "" . ';' . 'WirecardSeamlessBundle' . ';' . '1.1.0'));
			
	}
	
	
	public function getCustomerId(){
		return $this->customerId;
	}
	
	public function setCustomerId($customerId){
		$this->customerId = $customerId;
	}
	
	public function getLanguage(){
		return $this->language;
	}
	
	public function setLanguage($language){
		$this->language = $language;
	}
	
	public function getPaymentType(){
		return $this->paymentType;
	}
	
	public function setPaymentType($paymentType){
		$this->paymentType = $paymentType;
	}
	
	public function getAmount(){
		return $this->amount;
	}
	
	public function setAmount($amount){
		$this->amount = $amount;
	}
	
	public function getCurrency(){
		return $this->currency;
	}
	
	public function setCurrency($currency){
		$this->currency = $currency;
	}
	
	public function getOrderDescription(){
		return $this->orderDescription;
	}
	
	public function setOrderDescription($orderDescription){
		$this->orderDescription = $orderDescription;
	}
	
	public function getSuccessUrl(){
		return $this->successUrl;
	}
	
	public function setSuccessUrl($successUrl){
		$this->successUrl = $successUrl;
	}
	
	public function getCancelUrl(){
		return $this->cancelUrl;
	}
	
	public function setCancelUrl($cancelUrl){
		$this->cancelUrl = $cancelUrl;
	}
	
	public function getFailureUrl(){
		return $this->failureUrl;
	}
	
	public function setFailureUrl($failureUrl){
		$this->failureUrl = $failureUrl;
	}
	
	public function getServiceUrl(){
		return $this->serviceUrl;
	}
	
	public function setServiceUrl($serviceUrl){
		$this->serviceUrl = $serviceUrl;
	}
	
	public function getRequestFingerprintOrder(){
		return $this->requestFingerprintOrder;
	}
	
	public function setRequestFingerprintOrder($requestFingerprintOrder){
		$this->requestFingerprintOrder = $requestFingerprintOrder;
	}
	
	public function getRequestFingerprint(){
		return $this->requestFingerprint;
	}
	
	public function setRequestFingerprint($requestFingerprint){
		$this->requestFingerprint = $requestFingerprint;
	}
	
	public function getConfirmUrl(){
		return $this->confirmUrl;
	}
	
	public function setConfirmUrl($confirmUrl){
		$this->confirmUrl = $confirmUrl;
	}
	
	
	
	public function getFinancialInstitution(){
		return $this->financialInstitution;
	}
	
	public function setFinancialInstitution($financialInstitution){
		$this->financialInstitution = $financialInstitution;
	}
	
	public function getPendingUrl(){
		return $this->pendingUrl;
	}
	
	public function setPendingUrl($pendingUrl){
		$this->pendingUrl = $pendingUrl;
	}
	
	
	public function getNoScriptInfoUrl(){
		return $this->noScriptInfoUrl;
	}
	
	public function setNoScriptInfoUrl($noScriptInfoUrl){
		$this->noScriptInfoUrl = $noScriptInfoUrl;
	}
	
	public function getOrderNumber(){
		return $this->orderNumber;
	}
	
	public function setOrderNumber($orderNumber){
		$this->orderNumber = $orderNumber;
	}
	
	public function getWindowName(){
		return $this->windowName;
	}
	
	public function setWindowName($windowName){
		$this->windowName = $windowName;
	}
	
	public function getDuplicateRequestCheck(){
		return $this->duplicateRequestCheck;
	}
	
	public function setDuplicateRequestCheck($duplicateRequestCheck){
		$this->duplicateRequestCheck = $duplicateRequestCheck;
	}
	
	public function getCustomerStatement(){
		return $this->customerStatement;
	}
	
	public function setCustomerStatement($customerStatement){
		$this->customerStatement = $customerStatement;
	}
	
	public function getOrderReference(){
		return $this->orderReference;
	}
	
	public function setOrderReference($orderReference){
		$this->orderReference = $orderReference;
	}
	
	public function getTransactionIdentifier(){
		return $this->transactionIdentifier;
	}
	
	public function setTransactionIdentifier($transactionIdentifier){
		$this->transactionIdentifier = $transactionIdentifier;
	}
	
	public function getSecret() {
		return $this->secret;
	}
	
	public function setSecret( $secret) {
		$this->secret = $secret;
		return $this;
	}	
	
	public function getBasketAmount() {
		return $this->basketAmount;
	}
	
	public function setBasketAmount($basketAmount) {
		$this->basketAmount = $basketAmount;
		return $this;
	}
	
	public function getBasketCurrency() {
		return $this->basketCurrency;
	}
	
	public function setBasketCurrency( $basketCurrency) {
		$this->basketCurrency = $basketCurrency;
		return $this;
	}
	public function getBasketItems() {
		return $this->basketItems;
	}
	
	/**
	 * Generates the full parameter list for the basket items in basketItemList and also sets the basketItems attribute.
	 * @return Array
	 */
	public function getBasketItemList() {
	
		if(isset ($this->basketItemList) && count($this->basketItemList) > 0){
			$this->basketItems = count($this->basketItemList);
			
			$itemList = array();
					
			for($i = 0; i< $this->basketItems; $i++){
				$item = $this->basketItemList[$i];
				$itemList = array_merge($itemList, $item->getAttributeArray($i));
					
			}
			return $itemList;
		}else{
			return null;
		}
	}
	public function setBasketItemList($basketItemList) {
		$this->basketItemList = $basketItemList;
		return $this;
	}
	public function getAutoDeposit(){
		return $this->autoDeposit;
	}
	
	public function setAutoDeposit($autoDeposit){
		$this->autoDeposit = $autoDeposit;
	}
	
	public function getConfirmMail(){
		return $this->confirmMail;
	}
	
	public function setConfirmMail($confirmMail){
		$this->confirmMail = $confirmMail;
	}
	
	public function getShopId(){
		return $this->shopId;
	}
	
	public function setShopId($shopId){
		$this->shopId = $shopId;
	}
		
	public function getLog() {
		return $this->log;
	}
	public function setLog($log) {
		$this->log = $log;
		return $this;
	}
	public function getConsumerIpAddress() {
		return $this->consumerIpAddress;
	}
	public function setConsumerIpAddress($consumerIpAddress) {
		$this->consumerIpAddress = $consumerIpAddress;
		return $this;
	}
	public function getConsumerUserAgent() {
		return $this->consumerUserAgent;
	}
	public function setConsumerUserAgent($consumerUserAgent) {
		$this->consumerUserAgent = $consumerUserAgent;
		return $this;
	}
	public function getOrderIdent() {
		return $this->orderIdent;
	}
	public function setOrderIdent($orderIdent) {
		$this->orderIdent = $orderIdent;
		return $this;
	}
	public function getStorageId() {
		return $this->storageId;
	}
	public function setStorageId($storageId) {
		$this->storageId = $storageId;
		return $this;
	}
	public function getPluginVersion() {
		return $this->pluginVersion;
	}
	public function setPluginVersion($pluginVersion) {
		$this->pluginVersion = $pluginVersion;
		return $this;
	}
	
	
	
	
}