<?php
namespace WireCardSeamlessBundle\Resources;

use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use WireCardSeamlessBundle\Resources\Languages\LanguageManager;
use WireCardSeamlessBundle\Wirecard\WCResources;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\SystemInfo;
use SAP\EventTicketing\DataExchangeObject\Customer;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
class MyUtils{

	/**
	 * store gatewayData into the transaction object and write back to the given gatewayData reference
	 * @param PaymentTransaction $t
	 */
	public static function storeGatewayData(PaymentTransaction &$t, &$gatewayData, $key, $value){
		$success = false;
		$cnt = 1;
		$tmpKey = "";
		
		if($key == null || $key == "")
			return "";
			
		while(!$success){
			$tmpKey = $key.$cnt;
			if(!isset($t->gatewayData[$tmpKey])){
				$t->gatewayData[$tmpKey] = $value;
				$success = true;
			}else{
				$cnt++;
				continue;
			}					
		}

		MyLog::log ( $tmpKey." stored in gatewayData", $t, "debug" );
		MyLog::log($tmpKey." : \n".print_r($t->gatewayData[$tmpKey], true), $t, "verbose");

		$gatewayData = $t->gatewayData;
		
		return $tmpKey;
	}
	
	
	/**
	 * Returns the gatewayData as unserialized array (only for key serializedPaymentGateReturnValues)
	 * @param PaymentTransaction $t
	 */
	public static function accessGatewayData(PaymentTransaction $t){
		if(isset($t->gatewayData["serializedPaymentGateReturnValues"]))
			return unserialize($t->gatewayData["serializedPaymentGateReturnValues"]);
		else return array();
	}

	/**
	 * Returns all gatewayData action values as unserialized array (only for key 'notify' in 'serializedPaymentGateActionValues')
	 * @param PaymentTransaction $t
	 */
	public static function accessGatewayDataNotify(PaymentTransaction $t){
		if(isset($t->gatewayData["serializedPaymentGateActionValues"]['notify'])){
			$lastRequest = end($t->gatewayData['serializedPaymentGateActionValues']['notify']);
			return unserialize($lastRequest);			
		}else return array();
	}
	
	/**
	 * Returns the full gatewayData
	 * @param PaymentTransaction $t
	 */
	public static function accessFullGatewayData(PaymentTransaction $t){
		return $t->gatewayData;
	}
	
	/**
	 * Generates HTML data for a specific paymentType to view its Logo
	 * @param array $configParams
	 * @param string $payType
	 * @return string
	 */
	public static function generateLogoHTML($configParams, $payType){
		$htmlData = "";
		if(strpos($payType,"CCARD") !== false){
			$htmlData.= '<p class="payment-logo">';
			$supportedCardsTrimmed = preg_replace('/\s+/', '', $configParams["financialInstitution"]);
			$supportedCards = explode(",", $supportedCardsTrimmed);
			$creditCardImages = WCResources::getCreditCardImages($supportedCards);
			$i = 0;
			foreach ($creditCardImages as $image){
				$htmlData.='<img src="'.$image.'" width="100" alt="'.WCResources::$financialInstitutions["CCARD"][$supportedCards[$i]].'" />';
				$i++;
			}
			$htmlData.='</p>';
		}
		elseif(WCResources::getPaymentTypeImage($payType) != false){
			$htmlData.= '<p class="payment-logo">
								<img src="'.WCResources::getPaymentTypeImage($payType).'" width="150" alt="'.LanguageManager::getLanguageEntry($system->languageCode,$payType).'" />
							</p>';
		}
		
		return $htmlData;
	}
	
	/**
	 * Generates HTML data for a specific paymentType to view payment information as configured in $configParams
	 * @param boolean $needFinancialInstitution
	 * @param boolean $needsDS
	 * @param array $reqParams
	 * @param SystemInfo $system
	 * @param array $configParams
	 * @param int $step
	 * @param string $payType
	 * @return string
	 */
	public static function generatePayDataTableHTML( $needFinancialInstitution, $needsDS, $reqParams, SystemInfo $system, $configParams, $step, $payType){
		$tableData = "<table class='wirecard-payment-table'>";
		$viewedPayDataTrimmed = preg_replace('/\s+/', '', $configParams["viewPaymentData"]);
		$viewedPayData = explode(",", $viewedPayDataTrimmed);		
						
		foreach ($reqParams as $key=>$value) {
			if(in_array($key, $viewedPayData)){
				if( ($needFinancialInstitution || $needsDS) && $step==1 ){
					continue;
				}else{
					if($key == "paymentType"){
							$tableData.= "<tr>
											<td class='paymentleftcell' style='padding-right: 5px;'>".LanguageManager::getLanguageEntry($system->languageCode,"paymentTypeKey")."</td>
														<td class='paymentrightcell' style='padding:5px;'>".LanguageManager::getLanguageEntry($system->languageCode,$payType)."</td>
														</tr>";
					}else{
						$tableData.= "<tr>
										<td class='paymentleftcell' style='padding-right: 5px;'>".LanguageManager::getLanguageEntry($system->languageCode,$key."Key")."</td>
												<td class='paymentrightcell' style='padding:5px;'>$value</td>
												</tr>";
					}
				}
			}
		}

		return $tableData;
	}
	
	/**
	 * Generates HTML data for a specific paymentType to view a selectBox
	 * @param array $configParams
	 * @param string $paymentType
	 * @param SystemInfo $info
	 * @return string
	 */
	private static function generateSelectBoxHTML($configParams, $paymentType, SystemInfo $info){
		
		$select="
				<select id='selFinanceInst'>
	  				<option value='0'>".LanguageManager::getLanguageEntry($info->languageCode,"select.financialInst")." ..</option>";
		$explodedFinancialInstitution = array_merge(explode(",", $configParams["financialInstitution"]),
				explode(",", $configParams["financialInstitution1"]),
				explode(",", $configParams["financialInstitution2"]),
				explode(",", $configParams["financialInstitution3"]),
				explode(",", $configParams["financialInstitution4"]));
		 
		foreach(WCResources::getFinancialInstitut4PayType($paymentType) as $key => $value){
			if(in_array( $key, $explodedFinancialInstitution))
				$select.="<option value=".$key.">".utf8_decode($value)."</option>";
		}
		$select.= "</select>";
		
		return $select;
	}
	
	/**
	 * Generates HTML data for a specific paymentType to offer financial institution selection
	 * @param boolean $needFinancialInstitution
	 * @param int $step
	 * @param boolean $paymentType
	 * @param SystemInfo $info
	 * @param array $configParams
	 * @return string
	 */
	public static function generateTableForFinanceInst($needFinancialInstitution, $step, $paymentType, SystemInfo $info, $configParams){
		$tableData = "";
		if($needFinancialInstitution && $step == 2){
			$a = WCResources::getFinancialInstitut4PayType($paymentType);
		
			$tableData.= "<tr>
										<td class='paymentleftcell' style='padding-right: 5px;'>".LanguageManager::getLanguageEntry($info->languageCode,"financialInstitutionKey")."</td>
		  										<td class='paymentrightcell' style='padding:5px;'>".utf8_decode ($a[$_GET["wcfinanceInst"]])."</td>
		  										</tr>";
		}elseif($needFinancialInstitution && $step == 1){
			$select = self::generateSelectBoxHTML($configParams, $paymentType, $info);
		
			$tableData.= "<tr>
										<td class='paymentleftcell' style='padding-right: 5px;'>".LanguageManager::getLanguageEntry($info->languageCode,"financialInstitutionKey")."</td>
		  										<td class='paymentrightcell' style='padding:5px;'>".$select."</td>
		  										</tr>";
			 
		}
		
		return $tableData;
	}
	
	/**
	 * Build javascript for checkout
	 * @param string $url
	 * @param boolean $needsDS
	 * @param boolean $needFinancialInstitution
	 * @param string $orderIdent
	 * @return string
	 */
	public static function windowOpenURLBuilder($url, $needsDS, $needFinancialInstitution, $orderIdent ){
		
// 		$x ='window.open("'.$url;
		$x ='window.location.replace("'.$url;
		if($needsDS)
			$x .='&wcstorageId='.$_SESSION["wc_storage_id"].'&wcorderIdent='.$orderIdent;
		if($needFinancialInstitution)
			$x .= '&wcfinanceInst="+selValue+"';
		
		
		if(strpos($x, "dummy") != false)
			$x = self::manipulateUrlForShop($x);
		
// 		foreach ($_REQUEST as $key => $value) {
// 	                   $x .= "&$key=$value";
// 	                }
         return $x.'"';
		
	}
	
	/**
	 * Manipulate URLs coming from use in shops
	 * @param string $url
	 * @return string
	 */
	public static function manipulateUrlForShop($url){
		return str_replace ( "dummy=1" , "nextstate=9&addpay=1&orderbasket=1&agb=y", $url);
	}
	
	/**
	 * Check step of collectPaymentData call
	 * @param string $wcstorageId
	 * @param string $wcfinanceInst
	 * @return number
	 */
	public static function checkStep($wcstorageId, $wcfinanceInst ){
		if(isset($wcstorageId) || isset($wcfinanceInst)) 
			return 2;
		else return 1;
	}
	
	/**
	 * Check if the given $paymentType needs a DataStorage
	 * @param string $paymentType
	 * @return boolean
	 */
	public static function needDS($paymentType){
		if(WCResources::isSensibleDataNeeded($paymentType)) return true;
		else return false;
	}
	
	/**
	 * Check if the given $paymentType needs selection of a financial institution
	 * @param string $paymentType
	 * @return boolean
	 */
	public static function needsFinancialInstitution($paymentType){
		if (strpos($paymentType,"CCARD") !== false)
			return false;
		
		if(WCResources::getFinancialInstitut4PayType($paymentType) != false)
			return true;
		else return false;
	}
	
	public static function logVerboseData(PaymentTransaction $transaction, Customer $customer, Company $company, DialogData $dialogData, SystemInfo $system){
		MyLog::log ( "--------------  VERBOSE DATA OUTPUT  ---------------", $transaction, "verbose" );
		MyLog::log ( "Customer: " . print_r ( array_filter ( get_object_vars ( $customer ) ), true ), $transaction, "verbose" );
		MyLog::log ( "Company: " . print_r ( array_filter ( get_object_vars ( $company ) ), true ), $transaction, "verbose" );
		MyLog::log ( "Transaction: " . print_r ( array_filter ( get_object_vars ( $transaction ) ), true ), $transaction, "verbose" );
		MyLog::log ( "DialogData: " . print_r ( array_filter ( get_object_vars ( $dialogData ) ), true ), $transaction, "verbose" );
		MyLog::log ( "SystemInfo: " . print_r ( array_filter ( get_object_vars ( $system ) ), true ), $transaction, "verbose" );
		MyLog::log ( "-------------- END VERBOSE DATA OUTPUT  ---------------", $transaction, "verbose" );		
	}

	/**
	 * Write GET values to request object
	 * @param int $step
	 * @param boolean $needsDS
	 * @param boolean $needFinancialInstitution
	 * @param WCBasicPaymentRequest $reqObject
	 * @param string $wcstorageId
	 * @param string $wcorderIdent
	 * @param string $wcfinanceInst
	 */
	public static function setGETsByState($step, $needsDS, $needFinancialInstitution, $reqObject, $wcstorageId, $wcorderIdent, $wcfinanceInst){
		if ($step == 2) {
			if ($needsDS) {
				$reqObject->setStorageId ( $wcstorageId );
				$reqObject->setOrderIdent ( $wcorderIdent );
			} else {
				$reqObject->setStorageId ( null );
				$reqObject->setOrderIdent ( null );
			}
		
			if ($needFinancialInstitution)
				$reqObject->setFinancialInstitution ( $wcfinanceInst );
		} elseif (! $needsDS) {
			$reqObject->setOrderIdent ( null );
		}
	}
	
	/**
	 * Enlarge and put 04 at beginning of orderNumber if test mode
	 * @param WCBasicPaymentRequest $reqObject
	 * @param array $configParams
	 * @return string
	 */
	public static function enlargeOrderNumber($reqObject, $configParams){
		if($configParams["customerId"] == "D200411" && $configParams["shopId"] == "qmore3D" ){
			$enlargedOrderNumber = str_pad($reqObject->getOrderNumber(), 7, "0", STR_PAD_LEFT);
			return "04".$enlargedOrderNumber;
		}else return $reqObject->getOrderNumber();
	}
	
	/**
	 * Returns the corresponding javascript for the detected checkout method
	 * @param array $configParams
	 * @param string $redirectURL
	 * @return string
	 */
	public static function getCheckoutMethodJS($configParams, $redirectURL, SystemInfo $system, $paymentType){
		
		$checkoutMethod = self::detectCheckoutMethod($configParams["checkoutMethod"], $paymentType, $system);
		$intervalCode = '
					var timer = setInterval(function() {
						if (win.closed) {
							clearInterval(timer);
							document.getElementById("ok_ccsendquery").click();
						}
					}, 500);
				';
		
		switch($checkoutMethod){
			case "redirect":
				return 'window.location.replace("' . $redirectURL . '");';
			case "iframe":
				return 'var win = document.getElementById("checkoutFrame");'.$intervalCode;
			case "popup":
				return 'var win = window.open("' . $redirectURL . '","_blank");'.$intervalCode;
			default:
				return 'var win = window.open("' . $redirectURL . '","_blank");'.$intervalCode;
		}		
	}
	
	/**
	 * Checks the validity of the configured checkout method value.
	 * @param string $checkoutMethod
	 * @return string
	 */
	public static function validateCheckoutMethod($checkoutMethod){
		if($checkoutMethod != null){
			$trimmedLowerCase = strtolower(trim($checkoutMethod));
			switch ($trimmedLowerCase){
				case "":
					return "";
				case "popup":
					return "popup";
				case "redirect":
					return "redirect";
				case "iframe":
					return "iframe";
				default:
					return "";
			}
		}else return "";
	}

	/**
	 * Detects the checkout method depending on the configured value, the payment type and the used system (online shop or backend)
	 * @param string $checkoutMethod
	 * @param string $paymentType
	 * @param SystemInfo $system
	 * @return string
	 */
	public static function detectCheckoutMethod($checkoutMethod, $paymentType, SystemInfo $system){
		$validatedMethod = self::validateCheckoutMethod($checkoutMethod);		

		// ONLINE-SHOP
		if($system->onlineshop > 0){
			// The online-shop default checkout method is "iframe" ..
			if($validatedMethod == "iframe" || $validatedMethod == ""){
				// .. but if the paytype does not allow IFrames, then the online-shop default method is "redirect"
				if(WCResources::isIFrameForbidden($paymentType))
					return "redirect";
				// .. otherwise "iframe" will be returned
				else return "iframe";
			}	

			// The checkout method "redirect" is always possible in online-shops
			elseif ($validatedMethod=="redirect"){
					return "redirect";
			}		
			
			//	The checkout method "popup" is not supported in online-shops
			elseif ($validatedMethod=="popup"){
				if(WCResources::isIFrameForbidden($paymentType))
					return "redirect";				
				else return "iframe";
			}		
		}
		
		// BACKEND
		else{			
			// The backend default checkout method is "popup"
			if($validatedMethod == "popup" || $validatedMethod == "")
				return "popup";
				
			// "redirect" is not allowed at all for backend usage
			elseif ($validatedMethod == "redirect")
				return "popup";
			
			// If the checkout method is set to "iframe" ..
			elseif ($validatedMethod=="iframe"){
				// .. but the paytype does not allow IFrames, then the backend default method is applied (="popup")
				if(WCResources::isIFrameForbidden($paymentType))
					return "popup";
				// .. otherwise "iframe" will be returned
				else return "iframe";
			}			
		}
		
		// if for any reason nothing matched, return the always possible "popup"
		MyLog::log ( "WARNING: No checkout method matched: This should not happen ..", null, "debug" );
		return "popup";
	}
}