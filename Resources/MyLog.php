<?php

namespace WireCardSeamlessBundle\Resources; 

use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use Psr\Log\LoggerInterface;
class MyLog{
		
	/**
	 * Logs transaction information to a file
	 * @param string $msg
	 * @param PaymentTransaction $transaction
	 */
	public static function log($msg, PaymentTransaction $transaction=null, $logLevel = "info", $transactionId =null, LoggerInterface $sapetLog = null){
	  	
		include dirname(__FILE__).'/config/config.inc.php';
		$logSystem = "sapet";	// "sapet" for using SAPETs internal logging system only (only warnings, infos and errors). "all" for additionally log to $logDir
		
		
		if($logLevelConfig != "off" ){
			$sysId = $GLOBALS['global_system_id'];
			
			// log to files when dir is writable
			if($logDir != "" && is_writable($logDir."/".$sysId))
				$logSystem = "all";
			
			if($transaction == null && $transactionId != null)
				$thelog = self::genLogMsgTIDOnly($msg, $transactionId);
			else
				$thelog = self::genLogMsg($msg, $transaction, $logLevel);
						
			switch($logLevel){
				case "error":
					$sapetLog->error("ERROR: ".$msg);
					if($logSystem == "all" && ($logLevelConfig == "verbose" || $logLevelConfig == "debug" || $logLevelConfig == "prod")){	
							file_put_contents($logDir."/".$sysId."/".$product.".log", "ERROR:  ". $thelog, FILE_APPEND | LOCK_EX);
							file_put_contents($logDir."/".$sysId."/".$product."Info.log", "ERROR:  ". $thelog, FILE_APPEND | LOCK_EX);
					}
					break;
				case "warning":
					$sapetLog->warning("WARNING: ".$msg);
					if($logSystem == "all" && ($logLevelConfig == "verbose" || $logLevelConfig == "debug" || $logLevelConfig == "prod")){
							file_put_contents($logDir."/".$sysId."/".$product.".log", "WARNING:  ". $thelog, FILE_APPEND | LOCK_EX);
							file_put_contents($logDir."/".$sysId."/".$product."Info.log", "WARNING:  ". $thelog, FILE_APPEND | LOCK_EX);
					}
					break;
				case "ok":
					$sapetLog->info("OK: ".$msg);
					if($logSystem == "all" && ($logLevelConfig == "verbose" || $logLevelConfig == "debug" || $logLevelConfig == "prod")){
							file_put_contents($logDir."/".$sysId."/".$product.".log", "OK:  ". $thelog, FILE_APPEND | LOCK_EX);
							file_put_contents($logDir."/".$sysId."/".$product."Info.log", "OK:  ". $thelog, FILE_APPEND | LOCK_EX);
					}
					break;
				case "info":
					$sapetLog->info("INFO: ".$msg);
					if($logSystem == "all" && ($logLevelConfig == "verbose" || $logLevelConfig == "debug" || $logLevelConfig == "prod")){
							file_put_contents($logDir."/".$sysId."/".$product.".log",  "INFO:  ".$thelog, FILE_APPEND | LOCK_EX);
							file_put_contents($logDir."/".$sysId."/".$product."Info.log", "INFO:  ". $thelog, FILE_APPEND | LOCK_EX);
					}
					break;
				case "debug":	
// 					echo $msg;
// 					$sapetLog->debug("DEBUG: ".$msg);
					if($logSystem == "all" && ($logLevelConfig == "verbose" || $logLevelConfig == "debug"))
						file_put_contents($logDir."/".$sysId."/".$product."Info.log", "DEBUG: ". $thelog, FILE_APPEND | LOCK_EX);
					break;
				case "verbose":		// not available for SAPET logging
					if($logSystem == "all" && $logLevelConfig == "verbose")						
						file_put_contents($logDir."/".$sysId."/".$product."Info.log", "VERBOSE: ". $thelog, FILE_APPEND | LOCK_EX);
					break;
			}
		}			
	}

	/**
	 * Sends transaction information per email
	 * @param string $msg
	 * @param PaymentTransaction $transaction
	 * @return boolean
	 */
	public static function emailLog($to, $from, $msg, $transaction, LoggerInterface $log){
	  	
		include dirname(__FILE__).'/config/config.inc.php';
		if($logLevelConfig != "off"){
			if($to == null || $to == ""){
				self::log("eMail receiver not set, sending email aborted!", $transaction, "info", null, $log);
				return false;
			}
			if($from == null || $from == ""){
				self::log("eMail sender not set, sending email aborted!", $transaction, "info", null, $log);
				return false;
			}
			if($transaction == null){
				self::log("sending email aborted! ", $transaction, "info", null, $log);
				return false;
			}
	
			$thelog = self::genLogMsg($msg, $transaction, "info");
			$subject = $product." PayGate: TID ".$transaction->tid;
			$headers = 'From: '.$from."\r\n" .
					'Reply-To: '.$from."\r\n" .
					'X-Mailer: PHP/' . phpversion();
			 
			$success = mail($to, $subject, $thelog, $headers);
			 
		  	if($success)
			    	self::log("Sending eMail successful! (to: '".$to."', with subject: '".$subject."')", $transaction, "info", null, $log);
			  	else
			    	self::log("Sending eMail failed! (to: '".$to."', with subject: '".$subject."')", $transaction, "warning", null, $log);
			
			return $success;
		}
// 		else 
// 			echo $msg;
			
		return false;
	}
	
	/**
	 * log message generator including timestamp
	 * @param string $msg
	 * @param PaymentTransaction $transaction
	 * @param string $logLevel
	 * @return string
	 */
	private static function genLogMsg($msg, PaymentTransaction $transaction = null, $logLevel){
	  	// get the current gatewayData
	  	if($transaction != null) $gatewayData = MyUtils::accessGatewayDataNotify($transaction);

		$timestamp = gmdate("d-M-Y H:i:s")." UTC";
		if($transaction == null)
			return "[".$timestamp."] WARNING: transaction object is null! (Msg: ".$msg.")\n";
		else{
			if(isset($gatewayData)){
				$msg0 = "[".$timestamp."] TID ".$transaction->tid.": ";
				
// 				if(isset($gatewayData["paymentState"]))
					switch($gatewayData["paymentState"]){
						case "FAILURE":
							if($logLevel == "info")
								return $msg0.$msg." , ".$gatewayData["errors"]." error(s) occured, errorCode: ".$gatewayData["error_1_errorCode"].", Message: ".$gatewayData["error_1_message"].", consumerMessage: ".$gatewayData["error_1_consumerMessage"]."\n";
							
						case "CANCEL":
						case "SUCCESS":
						case "PENDING":
						default:
							if($logLevel == "info")
								return $msg0." - ".$msg." Amount: ".$gatewayData["amount"]." ".$gatewayData["currency"].", paymentType: ".$gatewayData["paymentType"].", (OrderNr: ".$gatewayData["orderNumber"].")\n";
							else return $msg0.$msg."\n";
							break;
					}
			}else {
				return "[".$timestamp."] TID ".$transaction->tid." (no gateway data available): ".$msg." , Amount: ".$transaction->value.", type: ".$transaction->type."\n";
			}
		}
	}
	
	/**
	 * log message generator including timestamp based on the transaction ID only
	 * @param string $msg
	 * @param string $transactionId
	 * @return string
	 */
	private static function genLogMsgTIDOnly($msg, $transactionId){

		$timestamp = gmdate("d-M-Y H:i:s")." UTC";
		return "[".$timestamp."] TID ".$transactionId.": ".$msg."\n";
	}
	
}