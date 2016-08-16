<?php

namespace WireCardSeamlessBundle\Wirecard;

use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\SystemInfo;
use WireCardSeamlessBundle\Resources\MyLog;
use WireCardSeamlessBundle\Resources\MyUtils;
use SAP\EventTicketing\Bundle\PaymentBundle\Exception\PaymentException;
use Psr\Log\LoggerInterface;
/**
 * Functions provided by Wirecard
 * @author schwaar GmbH, Wirecard CEE
 */
class WCFunctions {


	/**
	 * Returns the value for the request parameter "requestFingerprintOrder"
	 * @param array $theParams
	 */ 
	public static function genRequestFingerprintOrder($theParams) {
		$ret = "";
		foreach ($theParams as $key=>$value) {
			if($key != "requestFingerprintOrder" && $key != "secret")
				$ret .= "$key,";
		}
		$ret .= "requestFingerprintOrder,secret";
		return $ret;
	}
	
	/**
	 * Returns the value for the request parameter "requestFingerprint"
	 * @param array $theParams
	 * @param string $requestFingerprintOrder
	 * @param string $theSecret
	 * @return string
	 */
	public static function genRequestFingerprint($theParams, $requestFingerprintOrder, $theSecret) {
		$ret = "";
		foreach ($theParams as $key=>$value) {
			if($key != "requestFingerprintOrder" && $key != "secret")
				$ret .= "$value";
		}
		$ret .= "$requestFingerprintOrder";
		$ret .= "$theSecret";
		return hash_hmac("sha512", $ret, $theSecret);
	}
	
	
	
	/**
	 * Checks if response parameters are valid by computing and comparing the fingerprints
	 * @param array $theParams
	 * @param string $theSecret
	 * @return boolean
	 */
	public static function areReturnParametersValid($theParams, $theSecret) {
	
		// gets the fingerprint-specific response parameters sent by Wirecard
		$responseFingerprintOrder = isset($theParams["responseFingerprintOrder"]) ? $theParams["responseFingerprintOrder"] : "";
		$responseFingerprint = isset($theParams["responseFingerprint"]) ? $theParams["responseFingerprint"] : "";
	
		// values of the response parameters for computing the fingerprint
		$fingerprintSeed = "";
	
		// array containing the names of the response parameters used by Wirecard to compute the response fingerprint
		$order = explode(",", $responseFingerprintOrder);
	
		// checks if there are required response parameters in responseFingerprintOrder
		if (in_array ("paymentState", $order) && in_array ("secret", $order) ) {
			// collects all values of response parameters used for computing the fingerprint
			for ($i = 0; $i < count($order); $i++) {
				$name = $order[$i];
				$value = isset($theParams[$name]) ? $theParams[$name] : "";
				$fingerprintSeed .= $value; // adds value of response parameter to fingerprint
				if (strcmp($name, "secret") == 0) {
					$fingerprintSeed .= $theSecret; // adds your secret to fingerprint
				}
			}
			$fingerprint = hash_hmac('sha512', $fingerprintSeed, $theSecret); // computes the fingerprint
			// checks if computed fingerprint and responseFingerprint have the same value
			if (strcmp($fingerprint, $responseFingerprint) == 0) {
				return true; // fingerprint check passed successfully
			}
		}
		return false;
	}
	
	
	/**
	 * Checks the result of the payment state and returns an appropiate text message
	 * @param array $theParams
	 * @param string $theSecret
	 * @return string
	 */
	public static function handleCheckoutResult($theParams, $theSecret) {
		$paymentState = isset($theParams["paymentState"]) ? $theParams["paymentState"] : "";
		switch ($paymentState) {
			case "FAILURE":
				$error_message = isset($theParams["message"]) ? $theParams["message"] : "";
				$message = "An error occured during the checkout process: " . $error_message;
				// NOTE: please log this error message in a persistent manner for later use
				break;
			case "CANCEL":
				$message = "The checkout process has been cancelled by the user.";
				break;
			case "PENDING":
				if (self::areReturnParametersValid($theParams, $theSecret)) {
					$message = "The checkout process is pending and not yet finished.";
					// NOTE: please store all related information regarding the transaction
					//       in a persistant manner for later use
				} else {
					$message = "The verification of the returned data was not successful. ".
							"Maybe an invalid request to this page or a wrong secret?";
				}
				break;
			case "SUCCESS":
				if (self::areReturnParametersValid($theParams, $theSecret)) {
					$message = "The checkout process has been successfully finished.";
					// NOTE: please store all related information regarding the transaction
					//       in a persistant manner for later use
				} else {
					$message = "The verification of the returned data was not successful. ".
							"Maybe an invalid request to this page or a wrong secret?";
				}
				break;
			default:
				$message = "Error: The payment state $paymentState is not a valid state.";
				break;
		}
		return $message;
	}
	
	/**
	 * Sends a POST request to the given $url and in case of success returns the redirect URL
	 * @param string $url
	 * @param array $params
	 * @param PaymentTransaction $transaction
	 * @param SystemInfo $systemInfo
	 * @param string $returnRedirectUrl
	 * @param LoggerInterface $log
	 * @throws PaymentException
	 * @return string
	 */
	public static function postTo($url, $params, PaymentTransaction $transaction, SystemInfo $systemInfo, $returnRedirectUrl = false, LoggerInterface $log){

		MyLog::log("postTo: ".$url, $transaction, "debug");
		$postFields = http_build_query($params);
			
		MyLog::log("postTo: ".print_r( $postFields, true), $transaction, "verbose");
			
		// initializes the libcurl of PHP used for sending a POST request
		// to the Wirecard data storage as a server-to-server request
		// (please be aware that you have to use a web server where a
		// server-to-server request is enabled)
		$curl = curl_init();
			
		// sets the required options for the POST request via curl
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_PROXY, $systemInfo->httpProxy.":". $systemInfo->httpProxyPort);
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
		
		if(curl_error($curl) == ""){
			MyLog::log("curlResult received!", $transaction, "debug");
		}else MyLog::log("curlError: ".curl_error($curl),$transaction, "debug");

		MyUtils::storeGatewayData($transaction, $transaction->gatewayData, "paymentResponse", $curlResult);
		
		// closes the connection to the Wirecard Checkout Platform
		curl_close($curl);
			
		if($returnRedirectUrl){
			//--------------------------------------------------------------------------------//
			// Retrieves the value for the redirect URL.
			//--------------------------------------------------------------------------------//
				
			$redirectURL = "";
			$consumerMsg ="";
			foreach (explode('&', $curlResult) as $keyvalue) {
				$param = explode('=', $keyvalue);
				if (count($param) == 2) {
					$key = urldecode($param[0]);
					if ($key == "redirectUrl") {
						$redirectURL = urldecode($param[1]);
						MyLog::log("redirectURL: ".$redirectURL, $transaction, "debug");
						break;
					}
					if ($key == "error.1.consumerMessage") {
						$consumerMsg = urldecode($param[1]);
						break;
					}
				}
			}
			if($redirectURL == ""){
				MyLog::log("No redirectUrl returned: ".$curlResult, $transaction, "debug");
				throw new PaymentException($consumerMsg);
			}else 
				MyLog::log("Redirect URL received!", $transaction, "info", null, $log);
				
			return $redirectURL;
		}else return $curlResult;
	}
	
}