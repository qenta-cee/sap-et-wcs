<?php

namespace WireCardSeamlessBundle\Wirecard;


use WireCardSeamlessBundle\Resources\MyLog;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\SystemInfo;
use WireCardSeamlessBundle\Resources\MyUtils;
use WireCardSeamlessBundle\Resources\Languages\LanguageManager;
use SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException;
/**
 * Wirecard Seamless Back-end Operations
 * @author clic, Wirecard CEE
 */
class WCBackendOperations {

	private $password;
	private $customerId;
	private $language;
	private $orderNumber;
	private $amount;
	private $currency;
	private $paymentNumber;
	private $shopId;
	private $orderDescription;
	private $sourceOrderNumber;
	private $orderReference;
	private $customerStatement;
	private $creditNumber;
	private $fundTransferType;
	private $requestFingerprint;
	private $consumerEmail;
	private $consumerWalletId;

	private $command;
	private $secret;
	private $autoDeposit;
	
	
	// URLs for accessing the Wirecard Checkout Platform
	public $URL_APPROVE_REVERSAL = "https://checkout.wirecard.com/seamless/backend/approveReversal";
	public $URL_DEPOSIT = "https://checkout.wirecard.com/seamless/backend/deposit";
	public $URL_DEPOSIT_REVERSAL = "https://checkout.wirecard.com/seamless/backend/depositReversal";
	public $URL_GET_ORDER_DETAILS = "https://checkout.wirecard.com/seamless/backend/getOrderDetails";
	public $URL_RECUR_PAYMENT = "https://checkout.wirecard.com/seamless/backend/recurPayment";
	public $URL_REFUND = "https://checkout.wirecard.com/seamless/backend/refund";
	public $URL_REFUND_REVERSAL = "https://checkout.wirecard.com/seamless/backend/refundReversal";
	public $URL_TRANSFER_FUND = "https://checkout.wirecard.com/seamless/backend/transferFund";
	
	private $transaction;
	private $gatewayData;
	
	/**
	 * 
	 * @param PaymentTransaction $transaction
	 * @param unknown $configParams
	 * @param unknown $operation
	 * @param unknown $transactionId
	 * @param SystemInfo $systemInfo
	 * @param string $moreDetails
	 * @return multitype:string
	 * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	public function executeBackendOperation(PaymentTransaction $transaction, $configParams, $operation, $transactionId, SystemInfo $systemInfo, $moreDetails = null){
		
	  	// get the current gatewayData
		if($transaction != null){
			$this->gatewayData = MyUtils::accessGatewayDataNotify ( $transaction );
			$this->fullGatewayData = MyUtils::accessFullGatewayData($transaction);
		}

		MyLog::log("-> executeBackendOperation()",$transaction, "debug");
		$this->transaction = $transaction;
		
		$this->setupParameters($transaction, $configParams, $operation, $transactionId, $systemInfo, $moreDetails);
		MyLog::log("executeBackendOperation: parameter setup completed",$transaction, "debug");
		
		$path = dirname(__FILE__) . '/BackendOperations/'.$operation.'.php';
		if (realpath($path)) {
			include_once($path);
		}
		else{
			MyLog::log("executeBackendOperation: ERROR: Non-existing backend operation called!",$transaction, "debug");
		}		

		$request["_operation"] = $operation;
		
		if($transaction != null)
			MyUtils::storeGatewayData($transaction, $this->fullGatewayData, "backendOpRequest", $request);
		
		$this->printRequestParameters($request);
		$this->printResponseParameters($response);
			
		return $this->getResponseAsArray($response);
	}
	

	/**
	 * Setup parameters for backendOperation request
	 * @param PaymentTransaction $transaction
	 * @param WCBasicPaymentRequest $paymentRequestObject
	 * @param string $operation
	 * @param unknown $transactionId
	 * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	private function setupParameters($transaction, $configParams, $operation, $transactionId, SystemInfo $systemInfo, $moreDetails = null){
			//	all operations
			$this->command = $operation;
			$this->orderNumber = $transactionId;	//DONE: clarify if SAPET uses the externalId when calling getTransactionDetails(..) --> YES
			$this->password = $configParams["backendOpPassword"];
			$this->customerId =  $configParams["customerId"];
			$this->shopId =  $configParams["shopId"];
			$this->language =  $systemInfo->languageCode;
			$this->secret = $configParams["secret"];
	
			//	approveReversal, deposit, depositReversal, refundReversal, refund, recurPayment
			if($transaction != null){	
	
				//	deposit, refund, recurPayment
				if($this->command == "deposit" || $this->command == "refund" ||$this->command == "recurPayment"){
					// parse currency and amount
					$val = trim($transaction->value);
					$currency = substr($val,-1);
					$amount = substr($val,0,strlen($val)-1);
						
					if(($amount != false && $amount != "") && ($currency != false && $currency != "")){
						$this->amount = $amount;
						$this->currency = WCResources::$currencyTokens[$currency];
					}else{						
						throw new PaymentException(LanguageManager::getLanguageEntry($systemInfo->languageCode,"toolkit.setupParameters.parseamounterror"));
					}
				}
					
				//	depositReversal
				if($this->command == "depositReversal")
					if(array_key_exists("payment.1.1.paymentNumber", $this->fullGatewayData[$moreDetails]))
						$this->paymentNumber = $this->fullGatewayData[$moreDetails]["payment.1.1.paymentNumber"];
					else{						
						throw new PaymentException(LanguageManager::getLanguageEntry($systemInfo->languageCode,"toolkit.setupParameters.nodepositdataerror"));
					}
						
				//	refundReversal
				if($this->command == "refundReversal"){
					if(array_key_exists("credit.1.1.creditNumber", $this->fullGatewayData[$moreDetails]))
						$this->creditNumber = $this->fullGatewayData[$moreDetails]["credit.1.1.creditNumber"];
					else {
						throw new PaymentException(LanguageManager::getLanguageEntry($systemInfo->languageCode,"toolkit.setupParameters.norefunddataerror"));
					}
				}	
			}				
	}
	
	
	/**
	 * Compute sha512 fingerprint using the give parameter list
	 * @return string
	 */
	private function computeFingerprint() {
		$seed = "";
		for ($i=0; $i<func_num_args(); $i++) {
			$seed .= func_get_arg($i);
		}
		return hash_hmac("sha512", $seed, $this->secret);
	}
	
	/**
	 * 
	 * @param string $url
	 * @param array $params
	 * @param SystemInfo $systemInfo
	 * @throws PaymentException
	 * @return mixed
	 */
	private function serverToServerRequest($url, $params, SystemInfo $systemInfo) {
		$postFields = "";
		foreach ($params as $key => $value) {
			$postFields .= $key . "=" . $value . "&";
		}
		$postFields = substr($postFields, 0, strlen($postFields)-1);
	
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_PROXY, $systemInfo->httpProxy.":". $systemInfo->httpProxyPort);
		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		$response = curl_exec($curl);

		MyLog::log("backendOperations serverToServerRequest: ".curl_error($curl), $this->transaction, "debug");
		if(curl_error($curl) != ""){
			throw new PaymentException( LanguageManager::getLanguageEntry ( $this->system->languageCode, "backendOperationFailed" ) );
		}
		
		curl_close($curl);
		return $response;
	}
	
	/**
	 * Print request parameters
 	 * @copyright (c) 2013<br/>Wirecard Central Eastern Europe GmbH <br/>www.wirecard.at	
	 * @param array $params
	 */
	private function printRequestParameters($params) {
		MyLog::log("The request has been initialized with the following values:" , $this->transaction, "verbose");
		$s ="";
		foreach ($params as $key => $value) {
			$s.= $key . ' = ' . $value . ' , ';
		}
		MyLog::log($s , $this->transaction, "verbose");
	}

	/**
	 * Print response parameters
	 * @copyright (c) 2013<br/>Wirecard Central Eastern Europe GmbH <br/>www.wirecard.at
	 * @param string $response
	 */
	private function printResponseParameters($response) {
		MyLog::log("The Wirecard Checkout Platform returned the following values after executing the command:" , $this->transaction, "verbose");
		$s ="";
		foreach (explode('&', $response) as $keyvalue) {
			$param = explode('=', $keyvalue);
			if (count($param) == 2) {
				$key = urldecode($param[0]);
				$value = urldecode($param[1]);
				$s.= $key . ' = ' . $value . ' , ';
			}
		}
		MyLog::log($s , $this->transaction, "verbose");
	}

	/**
	 * Get response parameters as array
	 * @copyright (c) 2013<br/>Wirecard Central Eastern Europe GmbH <br/>www.wirecard.at
	 * @param string $response
	 * @return array $response
	 */
	private function getResponseAsArray($response) {
		$s = array();
		foreach (explode('&', $response) as $keyvalue) {
			$param = explode('=', $keyvalue);
			if (count($param) == 2) {
				$key = urldecode($param[0]);
				$value = urldecode($param[1]);
				$s[$key] = $value ;
			}
		}
		return $s;
	}
}
