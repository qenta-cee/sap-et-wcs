<?php

/****************************************************************/
/*																*/
/*	Wirecard Seamless payment gateway for SAPET					*/
/*																*/
/*	Copyright (c) schwaar GmbH, 2016 - All rights reserved		*/
/*																*/
/****************************************************************/

namespace WireCardSeamlessBundle;

use SAP\EventTicketing\Bundle\PaymentBundle\PaymentInterface;
use Psr\Log\LoggerInterface;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use SAP\EventTicketing\DataExchangeObject\User;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\SystemInfo;
use SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException;
use WireCardSeamlessBundle\Resources\Languages\LanguageManager;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\WCFunctions;
use WireCardSeamlessBundle\Resources\config\ConfigDialogParameters;
use WireCardSeamlessBundle\Resources\MyLog;
use WireCardSeamlessBundle\Wirecard\WCDataStorage;
use WireCardSeamlessBundle\Wirecard\WCBackendOperations;
use WireCardSeamlessBundle\Resources\MyUtils;


/**
 * This class PaymentProvider implements PaymentInterface the required functions for
 * the implementation of a Payment gateway.
 * It is designed to
 * support a two-step-payment process.
 *
 * class PaymentProvider implements PaymentInterface
 * 
 * @package SAP\EventTicketing\Bundle\PaymentBundle
 */
abstract class PaymentProvider implements PaymentInterface {
	protected $log;
	protected $user;
	protected $system;
	
	/**
	 * determines the gateways internal state<br/>
	 * 0 : first step of payment process, no gatewayData available in <i>$transaction</i> object<br/>
	 * 1 : paymentRequest data found in <i>$transaction->gatewayData</i>, so nothing returned by wirecard yet<br/>
	 * 2 : paymentResponse data found, so checkout process already took
	 * place and returned data via one of the before delivered URLs (success, cancel, ..)<br/>
	 * 3 : backendOperation response data found, so minimum one operation already took place<br/>
	 * -1 : false state
	 * 
	 * @var int
	 */
	protected $myState;
	
	/**
	 * Name of the payment gateway
	 * 
	 * @var string
	 */
	protected static $gatewayName;
	
	/**
	 * Payment type of the gateway
	 * 
	 * @var string
	 */
	protected static $paymentType;
	
	/**
	 * Request object containing parameters needed for the wirecard request
	 * 
	 * @var WCBasicPaymentRequest
	 */
	protected $paymentRequestObject;
	
	/**
	 * Request parameters containing all parameters as an Array.
	 * 
	 * @var array
	 */
	protected $requestParameters;
	
	/**
	 * Configuration Parameters of the payment gateway
	 * 
	 * @var Array
	 */
	protected $configurationParameters;
	
	/**
	 * Wirecard backendOperations request object.
	 * 
	 * @var WCBackendOperations
	 */
	protected $backendOperationObject;
	
	/**
	 * Persisted data of payment gateway (unserialized values returned by aquirer)
	 * 
	 * @var serialized string
	 */
	protected $gatewayData;	

	/**
	 * Full persisted data of payment gateway
	 *
	 * @var serialized string
	 */
	protected $fullGatewayData;
	
	
	// ************************ abstract methods ***************************************************
	 
	abstract protected function createRequestObject();
	
	
	// ************************ methods that are overridden when needed ****************************
	
	/**
	 * Used to read sensible input data via javascript
	 * @param array $configParams
	 * @return string
	 */
	protected function getSensitiveDataJS($configParams) {
		return "";
	}
	/**
	 * Used for DataStorage callback method
	 * @return string
	 */
	protected function getDataStoreCallbackJS() {
		return "";
	}
	/**
	 * Provides HTML for sensible data input
	 * @param unknown $configParams
	 * @return string
	 */
	protected function getSensitiveDataHTMLFields($configParams) {
		return "";
	}
	
	
	/**
	 * creates a new instance of a payment gateway with an interface
	 * to log information to the system
	 *
	 * @param LoggerInterface $logger
	 *        	instance of the used logger API
	 * @param SystemInfo $system
	 *        	information about the system
	 * @param User $user
	 *        	data about the current user
	 */
	public function __construct(LoggerInterface $logger, SystemInfo $system, User $user = null) {
		$this->log = $logger;
		$this->system = $system;
		$this->user = $user;
		
		// check if SAPET delivered valid parameters
		$this->validateInterfaceData ( $logger, $system, $user );
		
		// validate object properties to ensure a successful setup
		$this->validateSetup ();
	}
	
	/**
	 * check the license of the payment gateway, for the case
	 * that a special license is needed.
	 *
	 * @return boolean true if license is valid, otherwise false
	 */
	public static function checkLicense() {
		return true;
	}
	
	/**
	 * returns the name of the gateway.
	 *
	 * @return string the name of the gateway
	 */
	public static function getGatewayName() {
		self::$gatewayName = utf8_decode(WCResources::$paymentTypes [static::$paymentType]);
		
		return "WCS_" . self::$gatewayName;
	}
	
	/**
	 * Collects all the parameters necessary for the subsequent wirecard POST request.
	 * <b>Attention:</b> Collection of security critical payment data (and validation of those) is NOT part of this method but is handled on wirecard side - who is PCI-compliant and certified.
	 *
	 *
	 * @param DialogData $dialogData        	
	 * @param PaymentTransaction $transaction        	
	 * @param Company $company        	
	 * @param Customer $customer        	
	 * @return boolean true in case of success, otherwise false
	 *        
	 * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	public function collectPaymentData(DialogData $dialogData, PaymentTransaction $transaction, Company $company = null, Customer $customer = null) {
		try {
			
			// get the current gatewayData
			$this->gatewayData = MyUtils::accessGatewayDataNotify ( $transaction );
			$this->fullGatewayData = MyUtils::accessFullGatewayData($transaction);			
			
			// store dialogData URL for use in processNotify
			$transaction->gatewayData["dialogDataUrl"] = $dialogData->url;
			
			// setup current step and if data store is needed
			$step = MyUtils::checkStep ( $_GET ["wcstorageId"], $_GET ["wcfinanceInst"] );
			$needsDS = MyUtils::needDS ( static::$paymentType );
			$needFinancialInstitution = MyUtils::needsFinancialInstitution ( static::$paymentType );
			
			$converted_res = ($needsDS) ? 'true' : 'false';
			$converted_resfinance = ($needFinancialInstitution) ? 'true' : 'false';
						
			if ($step == 1) {
				MyLog::log ( "**********************************************************************", $transaction, "debug" );
				MyLog::log ( "*********************** collectPaymentData() *************************", $transaction, "debug" );
				MyLog::log ( "**********************************************************************", $transaction, "debug" );
				MyLog::log ( "Selected PayGate: " . WCResources::$paymentTypes [static::$paymentType] . " (" . static::$paymentType . ")", $transaction, "debug" );
				
				if ($needsDS) {
					// Initiate Date Storage and retrieve the javascriptURL for Wirecard functionality
					$dataStorage = new WCDataStorage ();
					$javascriptURL = $dataStorage->initDataStorage ( $this->configurationParameters, $dialogData, $transaction, $company, $customer, $this->system, $this->log );
					
				}
			}
			
			MyLog::log ( "collectPaymentData status: step = " . $step . ", needsDS = " . $converted_res . ", needsFinance = " . $converted_resfinance, $transaction, "debug" );
			MyLog::log ( "collectPaymentData GETs: wcstorageId = " . $_GET ["wcstorageId"] . ", wcorderIdent = " . $_GET ["wcorderIdent"] . ", wcfinanceInst = " . $_GET ["wcfinanceInst"], $transaction, "debug" );
				
			$this->init ( $transaction );
			$this->requestParameters = array ();
			
			// for readability..
			$reqObject = &$this->paymentRequestObject;
			$reqParams = &$this->requestParameters;
			
			$reqObject->setParameters ( $this->configurationParameters );
			$reqObject->setPaymentType ( static::$paymentType );
			$reqObject->setupRequestParameters ( $this->configurationParameters, $dialogData, $transaction, $company, $customer, $this->system);
			
			// enlarge and put 04 at beginning of orderNumber if test mode
			$reqObject->setOrderNumber(MyUtils::enlargeOrderNumber($reqObject, $this->configurationParameters));
			
			
			// some more params to set from here ..
			$reqObject->setLanguage ( $this->system->languageCode );
			$reqObject->setWindowName ( "checkoutFrame" );
			
			// write GET values to request object
			MyUtils::setGETsByState($step, $needsDS, $needFinancialInstitution, $reqObject, $_GET ["wcstorageId"], $_GET ["wcorderIdent"], $_GET ["wcfinanceInst"]);
			
			// map data from payment request object into array
			$reqParams = $reqObject->collectParameters ();
			
			// and then do the fingerprint stuff
			$reqObject->setRequestFingerprintOrder ( WCFunctions::genRequestFingerprintOrder ( $reqParams ) );
			$reqParams ["requestFingerprintOrder"] = $reqObject->getRequestFingerprintOrder ();
			$reqObject->setRequestFingerprint ( WCFunctions::genRequestFingerprint ( $reqParams, $reqParams ["requestFingerprintOrder"], $reqObject->getSecret () ) );
			$reqParams ["requestFingerprint"] = $reqObject->getRequestFingerprint ();
									
			// verbose data output
			MyUtils::logVerboseData($transaction,  $customer,  $company,  $dialogData,  $this->system);
			
			// generate HTML data for logo and payment data table
			$htmlData = MyUtils::generateLogoHTML($this->configurationParameters, static::$paymentType);
			if(strpos(static::$paymentType,"CCARD") !== false && $step == 1 && $GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] == "A"){
				$htmlData .= '<div id="ccDataIframe"></div>';
				$htmlData .= '<script type="text/javascript">
							// creates a new JavaScript object containing the Wirecard data storage functionality
				        	var dataStorage = new WirecardCEE_DataStorage();
							
							// loading input cc data input fields from wirecard as an IFrame (for PCI DSS SAQ A compliance)
							dataStorage.buildIframeCreditCard("ccDataIframe", "100%", "160px");
							</script>';
			
			}
			$htmlData .= MyUtils::generatePayDataTableHTML ( $needFinancialInstitution, $needsDS, $reqParams, $this->system, $this->configurationParameters, $step, static::$paymentType );	
			$htmlData .= MyUtils::generateTableForFinanceInst ( $needFinancialInstitution, $step, static::$paymentType, $this->system, $this->configurationParameters );	

			
			// use the javascript property of the dialogData object to provide javascript & view HTML ..			
			$dialogData->javascript = '<noscript>Please enable JavaScript!</noscript>';
			
			if ($needsDS && $step == 1) {
				$dialogData->javascript .= '
    				<script src="' . $javascriptURL . '" type="text/javascript"></script>';
				
				if(strpos(static::$paymentType,"CCARD") !== false && $GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] == "A"){	

					$htmlData .= "<tr><td class='paymentleftcell' style='padding-right: 5px;'></td><td class='paymentrightcell' style='padding:5px;'><input id='sendButton' value='" . LanguageManager::getLanguageEntry ( $this->system->languageCode, "button.continue" ) . "' onclick='callUrlWithFincanceInst();' type='button'></td>
					</tr>";
				}else{
					// add the HTML table for payment types needing sensible data input
					$htmlData .= $this->getSensitiveDataHTMLFields ($this->configurationParameters);
				}
			} elseif ($step == 1 && $needFinancialInstitution) {
				$htmlData .= "<tr><td class='paymentleftcell' style='padding-right: 5px;'></td><td class='paymentrightcell' style='padding:5px;'><input id='sendButton' value='" . LanguageManager::getLanguageEntry ( $this->system->languageCode, "button.continue" ) . "' onclick='callUrlWithFincanceInst();' type='button'></td>
					</tr>";
			}
			
			$dialogData->javascript .= '
	      		<script type=\'text/javascript\'>		
    				var showReserveButton = false;		    		
		     		function hide_button(){
		        		ccbutton = document.getElementById("ok_ccsendquery");
		        		if(ccbutton && !showReserveButton){
		          			ccbutton.style.display= "none";
		         		}
				        else{
				          	window.setTimeout("hide_button()", 100);	
		        		}
		       		}
					
					function running(){}					
					function b_ccsendquery(){}
								
			   		window.setTimeout("hide_button()", 100);    				
    				
    				';
			
			if ($needsDS && $step == 1) {
				$dialogData->javascript .= "
				// function for storing sensitive data to the Wirecard data storage
		      	function storeData(type) {
					var selIndex = -1;";
				if ($needFinancialInstitution)
					$dialogData->javascript .= "
					// get the financialInstitution selection
						 selIndex =	document.getElementById('selFinanceInst').selectedIndex;";
				$dialogData->javascript .= "
					if(selIndex == 0) alert('" . LanguageManager::getLanguageEntry ( $this->system->languageCode, "select.financialInst" ) . "!');
					else{";
				$dialogData->javascript .= "
				        // creates a new JavaScript object containing the Wirecard data storage functionality
				        var dataStorage = new WirecardCEE_DataStorage();";				
				$dialogData->javascript .= "
				        // initializes the JavaScript object containing the payment specific information and data
				        var paymentInformation = {};";
				
				
				// include payment type specific javascript data for payment types needing sensitive data input
				$dialogData->javascript .= $this->getSensitiveDataJS ($this->configurationParameters);
				
				$dialogData->javascript .= "}}";
				
				$dialogData->javascript .= '
						// callback function for displaying the results of storing the
	      				// sensitive data to the Wirecard data storage
			      		callbackFunction = function(aResponse) {
										
			        		// initiates the result string presented to the user
					        var s = "' . LanguageManager::getLanguageEntry ( $this->system->languageCode, "wirecard.datastorage.callbackalert.title" ) . ':\n\n";
					        // checks if response status is without errors
					        if (aResponse.getStatus() == 0) {
					        	// saves all anonymized payment information to a JavaScript object
					          	var info = aResponse.getAnonymizedPaymentInformation();';
				
				// include payment type specific javascript for storing sensitive data
				$dialogData->javascript .= $this->getDataStoreCallbackJS ();
				
				$dialogData->javascript .= '
							}else{
						          // collects all occured errors and adds them to the result string
						          var errors = aResponse.getErrors();
						          for (e in errors) {
						            s += "Error " + e + ": " + errors[e].message + " (Error Code: " + errors[e].errorCode + ")\n";
						          }
						    }
						        // presents result string to the user
						        //alert(s);
						';
				
				if (($needFinancialInstitution || $needsDS) && $GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] != "A")
					$dialogData->javascript .= ' callUrlWithFincanceInst();';
				
				$dialogData->javascript .= '}';
			}
			if (($needFinancialInstitution || $needsDS) && $step == 1) {
				$dialogData->javascript .= ' 
						
				function callUrlWithFincanceInst(){
					
					';
				if ($needFinancialInstitution){
					$dialogData->javascript .= '
					// get the financialInstitution selection
						 var selIndex = -1;
						 var selBox = document.getElementById("selFinanceInst");
						 selIndex =	selBox.selectedIndex;
							
					if(selIndex == 0) alert("' . LanguageManager::getLanguageEntry ( $this->system->languageCode, 'select.financialInst' ) . '!");
					else{
							// get the financialInstitution selection					
							var selValue = selBox.value;';
				}
				if($needsDS && $GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] == "A")
					$dialogData->javascript .= 'dataStorage.storeCreditCardInformation(null, callbackFunction);
							';
				
				$recallCollectStepUrl = MyUtils::windowOpenURLBuilder ( $dialogData->url, $needsDS, $needFinancialInstitution, $reqObject->getOrderIdent () );				
				MyLog::log ( "collectPaymentData: recallCollectStepUrl: ".$recallCollectStepUrl, $transaction, "debug" );
				$dialogData->javascript .= $recallCollectStepUrl;
				
				$dialogData->javascript .= ');';
			
				if ($needFinancialInstitution)
					$dialogData->javascript .= '}';

				$dialogData->javascript .= '}';
					
			}
			
			$dialogData->javascript .= "</script>";
			
			$redirectURL = "";
			$paymentIframe = "";
			
			// Start the checkout process for 'non-sensible' payment types. For 'sensible' payment types only if its already step 2
			if ($step == 2 || (! $needFinancialInstitution && ! $needsDS)) {
				// prepare and execute the curl POST request
				$redirectURL = WCFunctions::postTo ( WCDataStorage::$URL_FRONTEND_INIT, $this->requestParameters, $transaction, $this->system, true, $this->log );
				
				$dialogData->javascript .= '<script type="text/javascript">
				function waitForClick(){';
				
				$dialogData->javascript .= MyUtils::getCheckoutMethodJS($this->configurationParameters, $redirectURL, $this->system, static::$paymentType);
				$dialogData->javascript .= '}</script>';
				
				// generate HTML for checkout, depending on the detected checkout type
				$checkoutMethod = MyUtils::detectCheckoutMethod($this->configurationParameters["checkoutMethod"], static::$paymentType, $this->system);
				if($checkoutMethod == "iframe"){
					$paymentIframe = '<iframe align="left" id="checkoutFrame" style="display: block" name="checkoutFrame" src="' . $redirectURL . '" width="100%" frameborder="0" seamless="seamless" scrolling="auto" height="400" onload="waitForClick();"></iframe>';
				}else{ // redirect or popup
					$htmlData .= "<tr><td class='paymentleftcell' style='padding-right: 5px;'></td><td class='paymentrightcell' style='padding:5px;'><input id='checkoutButton' value='" . LanguageManager::getLanguageEntry ( $this->system->languageCode, "checkout" ) . "' onclick='waitForClick();' type='button'></td>
						</tr>";		
				}	
					
				// persist payment request data
				MyUtils::storeGatewayData ( $transaction, $this->fullGatewayData, "paymentRequest", $this->requestParameters );
				MyLog::log ( "gatewayData after collect: " . print_r (  $transaction->gatewayData , true ), $transaction, "debug" );				
			}

			// finally add the HTML
			$dialogData->javascript .= $htmlData."</table>".$paymentIframe;
			
			MyLog::log("dialogData->javascript: \n" . $dialogData->javascript, $transaction, "verbose" );
			
		} catch ( PaymentException $e ) {
			MyLog::log ( $e->getMessage ()." (in collectPaymentData)", $transaction, "error", null, $this->log );
			MyLog::log ( "Transaction data: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
			throw $e;
		} catch ( \Exception $ex ) {
			MyLog::log ( $ex->getMessage ()." (in collectPaymentData)", $transaction, "error", null, $this->log );
		}
		
		return true;
	}
	
	/**
	 * Maps data returned by wirecard after a payment process into a response object for further use.
	 *
	 *
	 * @param PaymentTransaction $transaction        	
	 * @param DialogData $dialogData        	
	 * @param string $orderType        	
	 * @return boolean true in case of success, otherwise false
	 *        
	 * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	public function reservePaymentData(PaymentTransaction $transaction, DialogData $dialogData, $orderType) {
		try {
			
			MyLog::log ( "---------------------------- reservePaymentData() ----------------------------", $transaction, "debug", null, $this->log );
			
			// get the current gatewayData
			$this->gatewayData = MyUtils::accessGatewayDataNotify ( $transaction );
			$this->fullGatewayData = MyUtils::accessFullGatewayData($transaction);	
			
			// store the data confirmed by Wirecard
			// if at this step gatewayData is empty, Wirecard didn't send the payment data to the confirmUrl .. whyever.
			MyUtils::storeGatewayData($transaction, $this->fullGatewayData, "confirmURLResponse", $this->gatewayData);
			
			// check the $transaction's state on my own..
			$this->init ( $transaction );

			
			if ($this->myState > 1) {
				if ($this->myState == 2) { // gateway data from payment response found
					$transaction->externalId = $this->gatewayData ["orderNumber"];
					$msg = WCFunctions::handleCheckoutResult ( $this->gatewayData, $this->configurationParameters ["secret"] );
										
					switch ($this->gatewayData ["paymentState"]) {
						case "SUCCESS" :
							MyLog::log ( $msg, $transaction, "ok", null, $this->log);
							$transaction->paymentStatus = "b";
							$transaction->orderId = $this->gatewayData ["transactionID"];
							if (strpos(static::$paymentType,"CCARD") !== false) {
								$transaction->ccBrand = $this->gatewayData ["financialInstitution"];
								$transaction->ownerName = $this->gatewayData ["cardholder"];
								$transaction->orderId = $this->gatewayData ["transactionID"];
								$transaction->month = substr ( $this->gatewayData ["expiry"], 0, 2 );
								$transaction->year = substr ( $this->gatewayData ["expiry"], 3, 4 );
							}
							MyLog::log ( "Transaction data after SUCCESS: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
							break;
						case "CANCEL" :
							MyLog::log ( $msg, $transaction, "info", null, $this->log);
							throw new PaymentException ( LanguageManager::getLanguageEntry ( $this->system->languageCode, "paymentCancelled" ) );
						case "FAILURE" :
							MyLog::log ( $msg, $transaction, "error", null, $this->log);
							throw new PaymentException ( LanguageManager::getLanguageEntry ( $this->system->languageCode, "paymentFailure" ) );
						case "PENDING" :
							MyLog::log ( $msg, $transaction, "info", null, $this->log);
							$transaction->paymentStatus = "t";
							
							// redirect URL must be set to enable automatic execution of reservePaymentData and finalize when notifyUrl is called.
							$transaction->gatewayData["redirectTo"] = $dialogData->url . '&nextstate=9&ccbutton=1&agb=y&datastorage=y';
							
							// Das Ticketsystem unterstützt PENDING für Trustly derzeit noch nicht
							if(static::$paymentType == "TRUSTLY")
								throw new PaymentException ( LanguageManager::getLanguageEntry ( $this->system->languageCode, "paymentPendingTrustly" ) );
							else 
								throw new PaymentException ( LanguageManager::getLanguageEntry ( $this->system->languageCode, "paymentPending" ) );
						default:
							MyLog::log ( $msg, $transaction, "info", null, $this->log);	
							break;						
					}
				}
			} elseif ($this->myState == 1 || $this->myState == 0) {
				throw new PaymentException ( LanguageManager::getLanguageEntry ( $this->system->languageCode, "reservePaymentData.nodatareturned" ) );
				return false;
			} else {
				throw new PaymentException ( LanguageManager::getLanguageEntry ( $this->system->languageCode, "reservePaymentData.invalidstate" ) );
				return false;
			}
		} catch ( PaymentException $e ) {
			MyLog::log ( $e->getMessage ()." (in reservePaymentData)", $transaction, "error", null, $this->log );
			MyLog::log ( "Transaction data: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
			throw $e;
		} catch ( \Exception $ex ) {
			MyLog::log ( $ex->getMessage ()." (in reservePaymentData)", $transaction, "error", null, $this->log );
		}
		
		return true;
	}
	
	/**
	 * Finalize the payment process by updating the <i>$transaction</i> object and (for CCards) do the deposit.
	 *
	 *
	 * @param PaymentTransaction $transaction        	
	 * @return boolean
	 *
	 * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	public function finalize(PaymentTransaction $transaction) {
		MyLog::log ( "++++++++++++++++++++++++++++ finalize() +++++++++++++++++++++++++++++", $transaction, "debug" );
		
		// get the current gatewayData
		$this->gatewayData = MyUtils::accessGatewayDataNotify ( $transaction );
		$this->fullGatewayData = MyUtils::accessFullGatewayData($transaction);
		
		try {
			$this->init ( $transaction );
			
			if ($this->myState >= 2) {
				
				// update the transaction object based on the paymentState and an additional getOrderDetails backendOperation request
				switch ($transaction->paymentStatus) {
					case "b" :
						
						if (WCResources::isToolkitOpAvailable ( static::$paymentType, 1 )) {
							// create object for backend operations
							if ($this->backendOperationObject == null)
								$this->backendOperationObject = new WCBackendOperations ();
							
							if (! isset ( $this->configurationParameters ["backendOpPassword"] )) {
								MyLog::log ( "No backendOperations password set! ", $transaction, "warning", null, $this->log );
							}
							
							$response = array ();
							$response = $this->backendOperationObject->executeBackendOperation ( $transaction, $this->configurationParameters, "deposit", $transaction->externalId, $this->system );
														
							if (! isset ( $response ) || empty ( $response )) {
								throw new PaymentException ( static::$paymentType . LanguageManager::getLanguageEntry ( $this->system->languageCode, "backendOperationFailed" ) );
							} else {
								// persist the backendOperation response
								$response["_operation"] = "deposit";
								$usedKey = MyUtils::storeGatewayData ( $transaction, $this->fullGatewayData, "backendOpResponse", $response );
								
								if ($this->fullGatewayData [$usedKey] ["status"] == 0) {
									$transaction->paymentStatus = "o";
									MyLog::log ( "Payment finalized successfully!", $transaction, "ok", null, $this->log );
									MyLog::log ( "Transaction data: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
								} else {
									MyLog::log ( "errorCode: " . $this->fullGatewayData[$usedKey] ["error.1.errorCode"], $transaction, "debug", null, $this->log );
									$msg = "Finalizing (deposit) failed with response status = " . $this->fullGatewayData [$usedKey] ["status"] . " and error code = ".$this->fullGatewayData[$usedKey] ["error.1.errorCode"];
									$emailMsg = "ERROR (status = " . $this->fullGatewayData[$usedKey] ["status"] . ") while trying to finalize payment! errorCode: " . $this->fullGatewayData[$usedKey] ["error.1.errorCode"];
									MyLog::emailLog ( $this->configurationParameters ["cashing_email"], $this->configurationParameters ["cashing_email"], $emailMsg, $transaction, $this->log  );
									throw new PaymentException ( $msg );
								}
							}
						} else {
							$transaction->paymentStatus = "o";
							MyLog::log ( "Payment finalized successfully! (no backend operation necessary)", $transaction, "ok", null, $this->log );
							MyLog::log ( "finalize: gatewayData after finalizing: " . print_r (  $transaction->gatewayData , true ), $transaction, "debug" );								
						}
						
						break;
					case "t" :
						throw new PaymentException (LanguageManager::getLanguageEntry ( $this->system->languageCode, "paymentStatusTemporary" ));
						break;
					case "o" :
						throw new PaymentException (LanguageManager::getLanguageEntry ( $this->system->languageCode, "paymentStatusOrdered" ));
						break;
				}
			}
		} catch ( PaymentException $e ) {
			MyLog::log ( $e->getMessage ()." (in finalize)", $transaction, "error", null, $this->log );
			MyLog::log ( "Transaction data: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
			throw $e;
		} catch ( \Exception $ex ) {
			MyLog::log ( $ex->getMessage()." (in finalize)", $transaction, "error", null, $this->log );
		}		
		
		return true;
	}
	
	/**
	 * cancel and rollback the executed reservation
	 *
	 * @param PaymentTransaction $transaction        	
	 * @return boolean
	 *
	 * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	public function cancelReserve(PaymentTransaction $transaction) {
		
		// prepare and execute a approveReversal operation from backendOperations
		
		/*
		 * This operation cancels an approval. This can only be done when the approval has not yet been debited
		 * and is supported by the financial service provider.
		 */
		MyLog::log ( "xxxxxxxxxxxxxxxxxxxxxxxxxx cancelReserve() xxxxxxxxxxxxxxxxxxxxxxxxxxxx", $transaction, "debug" );
		
		// get the current gatewayData
		$this->gatewayData = MyUtils::accessGatewayDataNotify ( $transaction );
		$this->fullGatewayData = MyUtils::accessFullGatewayData($transaction);
		
		try {
			$this->init ( $transaction );
			
			$resultParams = array ();
			if (WCResources::isToolkitOpAvailable ( static::$paymentType, 0 )) {
				// create object for backend operations
				if ($this->backendOperationObject == null)
					$this->backendOperationObject = new WCBackendOperations ();
				
				if (! isset ( $this->configurationParameters ["backendOpPassword"] )) {
					MyLog::log ( "No backendOperations password set! ", $transaction, "warning", null, $this->log );
				}
				
				$resultParams = $this->backendOperationObject->executeBackendOperation ( $transaction, $this->configurationParameters, "approveReversal", $transaction->externalId, $this->system );
				
			} else {
				MyLog::emailLog ( $this->configurationParameters ["cashing_email"], $this->configurationParameters ["cashing_email"], "\n\nATTENTION: \n\nTransaction cancelled after successful checkout process, but " . static::$paymentType . " does not support cancelling! \n\nPlease check!\n\n", $transaction, $this->log  );
				throw new PaymentException ( "ATTENTION: " . static::$paymentType . LanguageManager::getLanguageEntry ( $this->system->languageCode, "cancelReserve.notsupportedcancel" ) );
			}
			
			if (! isset ( $resultParams ) || empty ( $resultParams )) {
				throw new PaymentException ( static::$paymentType . LanguageManager::getLanguageEntry ( $this->system->languageCode, "cancelReserve.toolkitfailed" ) );
			} else {
				// persist the backendOperation response
				$resultParams["_operation"] = "approveReversal";
				$usedKey = MyUtils::storeGatewayData ( $transaction, $this->fullGatewayData, "backendOpResponse", $resultParams );
				
				if ($this->fullGatewayData[$usedKey] ["status"] == 0) {
					MyLog::log ( "Transaction cancelled after successful checkout process!", $transaction, "info", null, $this->log );
					MyLog::log ( "cancelReserve: gatewayData after cancelling: " . print_r (  $transaction->gatewayData , true ), $transaction, "debug" );
				} else {
					$msg = "(status = " . $this->fullGatewayData[$usedKey] ["status"] . ") while trying to cancel payment after successful checkout! errorCode: " . $this->fullGatewayData[$usedKey] ["error.1.errorCode"];
					MyLog::emailLog ( $this->configurationParameters ["cashing_email"], $this->configurationParameters ["cashing_email"], "ERROR ".$msg, $transaction );
					throw new PaymentException ( $msg );
				}
				return true;
			}
		} catch ( PaymentException $e ) {
			MyLog::log ( $e->getMessage()." (in cancelReserve)", $transaction, "error", null, $this->log );
			MyLog::log ( "Transaction data: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
			throw $e;
		} catch ( \Exception $ex ) {
			MyLog::log ( $ex->getMessage()." (in cancelReserve)", $transaction, "error", null, $this->log );
		}		
		
		return true;
	}
	
	/**
	 * pay back the value based on the transaction amount
	 *
	 * @param PaymentTransaction $transaction        	
	 * @return boolean
	 *
	 * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	public function cancelByReference(PaymentTransaction $transaction) {
		
		// prepare and execute a refund operation from backendOperations
		
		/*
		 * This operation creates a credit note for the specified order.
		 * This operation can only be done after the order has been debited and the corresponding
		 * day-end closing has been done and the financial service provider supports this operation.
		 */

		MyLog::log ( "xxxxxxxxxxxxxxxxxxxxxxxxxx cancelByReference() xxxxxxxxxxxxxxxxxxxxxxxxxxxx", $transaction, "debug" );
		MyLog::log ( "--> transaction gatewayData: " . print_r (  $transaction->gatewayData , true ), $transaction, "debug" );
		
		// get the current gatewayData
		$this->gatewayData = MyUtils::accessGatewayDataNotify($transaction);
		$this->fullGatewayData = MyUtils::accessFullGatewayData($transaction);
		
		try{
			$operation = "none";
					
			// check the status at wirecard by doing a getOrderDetails
			MyLog::log("call getOrderDetails to check payment status", $transaction, "debug");
			$orderDetails = $this->getOrderDetails($transaction);
			
			if(!empty($orderDetails)){
				MyLog::log("--> getOrderDetails returned some values!", $transaction, "debug");
				$usedKey1 = $orderDetails["_usedKey"];
				$paymentCurrency = $orderDetails["payment.1.1.currency"];				
				$val = trim($transaction->value);
				$transactionCurrency = WCResources::$currencyTokens[substr($val,-1)];
				
				if($paymentCurrency != $transactionCurrency)
					throw new PaymentException("Currency must be ".$paymentCurrency);
				
				if($orderDetails["payment.1.1.state"] == "payment_deposited"){
					throw new PaymentException("Deposit reversal is not supported! Please try again after the day-end closing!");
				}elseif ($orderDetails["order.1.state"] == "REFUNDABLE"){
					MyLog::log("Payment state = REFUNDABLE -> operation set to refund!", $transaction, "info", null, $this->log);
					$operation = "refund";
				}
			}else{
				throw new PaymentException("Request for order details returned no results");
			}
			
			if($operation != "none"){			
	
					$this->init ( $transaction );
						
					$resultParams = array ();
					
					if($operation == "depositReversal") $op = 2;
					else if($operation == "refund") $op = 5;
					
					if (WCResources::isToolkitOpAvailable ( static::$paymentType, $op )) {
						// create object for backend operations
						if ($this->backendOperationObject == null)
							$this->backendOperationObject = new WCBackendOperations ();
				
						if (! isset ( $this->configurationParameters ["backendOpPassword"] )) 
							MyLog::log ( "No backendOperations password set! ", $transaction, "warning", null, $this->log );						
				
						$resultParams = $this->backendOperationObject->executeBackendOperation ( $transaction, $this->configurationParameters, $operation, $transaction->externalId, $this->system, $usedKey1 );
						
					} else {
						MyLog::emailLog ( $this->configurationParameters ["cashing_email"], $this->configurationParameters ["cashing_email"], "\n\nATTENTION: \n\nTransaction cancelled by reference (via ".$operation."), but " . static::$paymentType . " does not support that! \n\nPlease check!\n\n", $transaction, $this->log );
						throw new PaymentException ( "ATTENTION: " . static::$paymentType . LanguageManager::getLanguageEntry ( $this->system->languageCode, "cancelReserve.notsupportedcancelbyref" ) );
					}
						
					if (! isset ( $resultParams ) || empty ( $resultParams )) {
						throw new PaymentException ( static::$paymentType . LanguageManager::getLanguageEntry ( $this->system->languageCode, "backendOperationFailed" ) );
					} else {
						// persist the backendOperation response
						$resultParams["_operation"] = $operation;
						$usedKey = MyUtils::storeGatewayData ( $transaction, $this->fullGatewayData, "backendOpResponse", $resultParams );
				
						if ($this->fullGatewayData[$usedKey] ["status"] == 0) {
							MyLog::log ( "Transaction cancelled by reference!", $transaction, "ok", null, $this->log );
							MyLog::log ( "--> cancelByReference: Transaction data after cancelling by reference: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
						} else {
							$msg = "(status = " . $this->fullGatewayData[$usedKey] ["status"] . ") while trying to cancel payment by reference! \n\nerrorCode: " . $this->fullGatewayData[$usedKey] ["error.1.errorCode"] . " \nmessage: ".$this->fullGatewayData[$usedKey] ["error.1.message"]."\n\n";
							MyLog::emailLog ( $this->configurationParameters ["cashing_email"], $this->configurationParameters ["cashing_email"], "ERROR ".$msg, $transaction );
							throw new PaymentException ( $msg );
						}
						return true;
					}
				
						
			}else{
				$state = "";
				if(!empty($orderDetails))
					$state = $orderDetails["payment.1.1.state"];
				
				throw new PaymentException("Payment has no valid state: ".$state);
			}

		} catch ( PaymentException $e ) {
			MyLog::log ( $e->getMessage()." (in cancelByReference)", $transaction, "error", null, $this->log );
			MyLog::log ( "Transaction data: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
			throw $e;
		} catch ( \Exception $ex ) {
			MyLog::log ( $ex->getMessage()." (in cancelByReference)", $transaction, "error", null, $this->log );
		}
		return true;
	}
	
	/**
	 * processNotify
	 *
	 * @param PaymentTransaction $transaction
	 * @return boolean
	 *
	 * @throws \SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException
	 */
	public function processNotify(PaymentTransaction $transaction) {
		MyLog::log ( "executing processNotify()", $transaction, "info", null, $this->log );
			
		try{			
			// get all gatewayData delivered via the notifyUrl
			$this->gatewayData = MyUtils::accessGatewayDataNotify($transaction);
			
			$transaction->gatewayData["processNotifyCalled"] = "processNotifyCalled = true";
			
			// check the $transaction's state on my own..
			$this->init ( $transaction );			
				
			if ($this->myState > 1) {
				if ($this->myState == 2) { // gateway data from payment response found
					$msg = WCFunctions::handleCheckoutResult ( $this->gatewayData, $this->configurationParameters ["secret"] );
			
					switch ($this->gatewayData ["paymentState"]) {
						case "PENDING" :
							MyLog::log ( $msg." (in processNotify)", $transaction, "error", null, $this->log);
							$transaction->paymentStatus = "t";

							// redirect URL must be set to enable automatic execution of reservePaymentData and finalize when notifyUrl is finally called with success notification.
							$transaction->gatewayData["redirectTo"] = $transaction->gatewayData["dialogDataUrl"] . '&nextstate=9&ccbutton=1&agb=y&datastorage=y';
							
							return PaymentInterface::PROCESSNOTIFY_WAIT;								
					}
				}
			} elseif ($this->myState == 1 || $this->myState == 0) {
				throw new PaymentException ( LanguageManager::getLanguageEntry ( $this->system->languageCode, "reservePaymentData.nodatareturned" ) );
				return false;
			} else {
				throw new PaymentException ( LanguageManager::getLanguageEntry ( $this->system->languageCode, "reservePaymentData.invalidstate" ) );
				return false;
			}
		} catch ( PaymentException $e ) {
			MyLog::log ( $e->getMessage()." (in processNotify)", $transaction, "error", null, $this->log );
// 			MyLog::log ( "Transaction data: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
			throw $e;
		} catch ( \Exception $ex ) {
			MyLog::log ( $ex->getMessage()." (in processNotify)", $transaction, "error", null, $this->log );
		}
		
		return PaymentInterface::PROCESSNOTIFY_CONTINUE;
	}
	
	/**
	 * returns the relevant text for the given language key and language.
	 *
	 * @param
	 *        	$language
	 * @param
	 *        	$languagekey
	 * @return string the text for the relevant language key and language
	 */
	public function getLanguageEntry($language, $languagekey) {
		return LanguageManager::getLanguageEntry ( $language, $languagekey );
	}
	
	/**
	 * returns a list of required parameters for the payment gateway.
	 * This list will be processed within a configuration dialog.
	 * The value-key can contain a simple string or a list of items, which should have the keys value and languagekey.
	 * The value-key will be used as default value for the specific parameter.
	 * The mandatory-key specifies if a parameter is required or not.
	 * The used language keys will be used to call getLanguageEntry().
	 *
	 * format: array( key => array( value => [string|array(value => string, languagekey => string]
	 * mandatory => true|false
	 * languagekey => string
	 * )
	 * );
	 * 
	 * @return array if <i>$paymentRequestObject</i> is set. Empty array otherwise.
	 */
	public function getPossibleConfigParameters() {
		return ConfigDialogParameters::getAllConfigParams ( static::$paymentType );
	}
	
	/**
	 * set the configuration of the payment gateway
	 *
	 * format: array( key => value );
	 * 
	 * @param array $parameters        	
	 */
	public function setConfigurationParameters($parameters) {
		$this->configurationParameters = $parameters;
		$GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] = preg_replace('/\s+/', '', $this->configurationParameters["pciDssSaq"]);				
	}
	
	/** 
	 * returns information for a given transaction ID<br/>
	 * METHOD CURRENTLY NOT USED BY SAP-ET<br/>
	 * @param $transactionId
	 * @param bool $moreDetails        	
	 * @return array list of information for this transaction
	 */
	public function getTransactionDetails($transactionId, $moreDetails = false) {
		
		// METHOD CURRENTLY NOT USED BY SAP-ET
		
		MyLog::log("-> xxxxxxxxxxxxxxxxxxxxxxxxxx getTransactionDetails() xxxxxxxxxxxxxxxxxxxxxxxxxxxx", null, "debug");

		return array();
	}
	
	/**
	 * Validates the data delivered by SAPET via the Interface
	 * 
	 * @param LoggerInterface $logger        	
	 * @param SystemInfo $system        	
	 * @param User $user        	
	 */
	public function validateInterfaceData(LoggerInterface $logger, SystemInfo $system, User $user) {
		if (! isset ( $logger )) {
			MyLog::log ( "No LoggerInterface object set! ", null, "warning", null, $this->log );
			return;
		}
		if (! isset ( $system )) {
			MyLog::log ( "No system object set! ", null, "warning", null, $this->log );
		}
		if (! isset ( $user )) {
			MyLog::log ( "No user object set! ", null, "warning", null, $this->log );
		}
	}
	
	/**
	 * Checks if the payment type and the gateway name are set
	 */
	public function validateSetup() {
		if (! isset ( static::$paymentType ))
			MyLog::log ( "Payment type is not set!", null, "error", null, $this->log );
		
		if (! isset ( self::$gatewayName ))
			MyLog::log ( "Gateway name is not set!", null, "error", null, $this->log );
	}
	
	public function init(PaymentTransaction $transaction) {
		// check if there is already some data available for this transaction
		if (isset ( $this->gatewayData ) && ! empty ( $this->gatewayData )) {
			
			// check the transaction object's gatewayData			
			MyLog::log ( "gatewayData: " . print_r ( $this->gatewayData, true ), $transaction, "verbose" );
			
			if (array_key_exists ( "backendOpResponse1", $this->fullGatewayData )) { // $transaction contains data from a backend operation response
				$this->myState = 3;
			} elseif (array_key_exists ( "paymentState", $this->gatewayData )) { // $transaction contains data from a payment response (returned by wirecard via dialogData->notifyUrl)
				$this->myState = 2;
			} elseif (array_key_exists ( "paymentRequest1", $this->fullGatewayData )) { // $transaction contains data stored before sending the payment request
				$this->createRequestObject ();
				$this->myState = 1;
			} else {
				MyLog::log ( "Transaction object contains invalid gatewayData!", $transaction, "warning", null, $this->log );
				$this->createRequestObject ();
				$this->myState = - 1;
			}
			
			// no data, so this seems to be the beginning of the payment process.
		} else {
			// create new payment request object, which will contain the necessary parameters for the wirecard request
			MyLog::log ( "init: no gateway data! ", $transaction, "debug" );
			$this->createRequestObject ();
			$this->myState = 0;
		}
		
		MyLog::log ( "init: state = $this->myState", $transaction, "debug" );
	}
	
	/**
	 * This operation returns all details for a given order including all possible operations, corresponding payments and credit notes.
	 * @param PaymentTransaction $transaction
	 * @throws PaymentException
	 * @return array
	 */
	public function getOrderDetails(PaymentTransaction $transaction){
		// prepare and execute a getTransactionDetails operation from backendOperations
		
		// get the current gatewayData
				$this->gatewayData = MyUtils::accessGatewayDataNotify($transaction);
				$this->fullGatewayData = MyUtils::accessFullGatewayData($transaction);
		
		MyLog::log("-> xxxxxxxxxxxxxxxxxxxxxxxxxx getOrderDetails() xxxxxxxxxxxxxxxxxxxxxxxxxxxx", $transaction, "debug");
		
		$resultParams = array ();
		
		try {
			$this->init ( $transaction );
		
				
			// create object for backend operations
			if ($this->backendOperationObject == null)
				$this->backendOperationObject = new WCBackendOperations ();
		
			if (! isset ( $this->configurationParameters ["backendOpPassword"] ))
					MyLog::log ( "No backendOperations password set! ", $transaction, "warning", null, $this->log );			
		
			$resultParams = $this->backendOperationObject->executeBackendOperation ( $transaction, $this->configurationParameters, "getOrderDetails", $transaction->externalId, $this->system );
					
			if (! isset ( $resultParams ) || empty ( $resultParams )) {
				throw new PaymentException ( static::$paymentType . LanguageManager::getLanguageEntry ( $this->system->languageCode, "getOrderDetails.backendOpFailed" ) );
			} else {
				// persist the backendOperation response
				$resultParams["_operation"] = "getOrderDetails";
				$usedKey = MyUtils::storeGatewayData ( $transaction, $this->fullGatewayData, "backendOpResponse", $resultParams );
				$resultParams["_usedKey"] = $usedKey;
				
				if ($resultParams["status"] == 0) {
					MyLog::log ( "Order details received" , $transaction, "info", null, $this->log );
					MyLog::log ( "Order details: " . print_r ( $resultParams, true ), $transaction, "debug" );
				} else {
					$msg = "ERROR (status = " . $resultParams["status"] . ") while trying to receive order details! errorCode: " . $resultParams ["error.1.errorCode"];
					throw new PaymentException ( $msg );
				}
			}
		} catch ( PaymentException $e ) {
			MyLog::log ( $e->getMessage()." (in getOrderDetails)", $transaction, "error", null, $this->log );
			MyLog::log ( "Transaction data: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "debug" );
			throw $e;
		} catch ( \Exception $ex ) {
			MyLog::log ( $ex->getMessage()." (in getOrderDetails)", $transaction, "error", null, $this->log );
		}		
		
		return $resultParams;
	}
} 