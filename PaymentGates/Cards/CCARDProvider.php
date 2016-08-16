<?php

namespace WireCardSeamlessBundle\PaymentGates\Cards;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Cards\CCARDRequest;
use WireCardSeamlessBundle\Resources\Languages\LanguageManager;
use WireCardSeamlessBundle\Resources\MyLog;

class CCARDProvider extends PaymentProvider {

	static protected $paymentType = "CCARD";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new CCARDRequest();
	}
	
	protected function getSensitiveDataJS($configParams){
		if($GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] == "A")
			return "";
		elseif ($GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] == "A-EP"){

			$additionalFieldsTrimmed = preg_replace('/\s+/', '', $configParams["ccAdditionalFields"]);
			$additionalFields = explode(",", $additionalFieldsTrimmed);
			
			$jsData = "if (!document.getElementById('cc_pan')) {
		            dataStorage.storeCreditCardInformation(null, callbackFunction);
		          } else {";
			if(in_array("cardholdername", $additionalFields))
		            $jsData .= "paymentInformation.cardholdername = document.getElementById('cc_cardholdername').value;";
			$jsData .= "paymentInformation.pan = document.getElementById('cc_pan').value;
		            paymentInformation.expirationMonth = document.getElementById('cc_expirationMonth').value;
		            paymentInformation.expirationYear = document.getElementById('cc_expirationYear').value;";
			if(in_array("cardverifycode", $additionalFields))
		            $jsData .= "paymentInformation.cardverifycode = document.getElementById('cc_cardverifycode').value;";
			if(in_array("issueDate", $additionalFields)){
		            $jsData .= "paymentInformation.issueMonth = document.getElementById('cc_issueMonth').value;";
		            $jsData .= "paymentInformation.issueYear = document.getElementById('cc_issueYear').value;";
			}if(in_array("issueNumber", $additionalFields))
		            $jsData .= "paymentInformation.issueNumber = document.getElementById('cc_issueNumber').value;";
			
			$jsData .= "
            // stores sensitive data to the Wirecard data storage
            dataStorage.storeCreditCardInformation(paymentInformation, callbackFunction);
		          }";
			return $jsData;
		}else 
			MyLog::log("ATTENTION: Wrong PCI DSS SAQ configured: ".$GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"], null) ;
			
		return "";
	}

	protected function getSensitiveDataHTMLFields($configParams){

		if($GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] == "A")
			return "";
		elseif ($GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"] == "A-EP"){

			$additionalFieldsTrimmed = preg_replace('/\s+/', '', $configParams["ccAdditionalFields"]);
			$additionalFields = explode(",", $additionalFieldsTrimmed);
		
			$html ="";
			if(in_array("cardholdername", $additionalFields))
	            $html .= '<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"cardholdername").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="cc_cardholdername" autocomplete="off"></td></tr>';
	        $html .='
				<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"pan").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="cc_pan" autocomplete="off"></td></tr>';
		   	$html .='
	        	<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"expirationDate").'</td><td class="paymentrightcell" style="padding:5px;">
	        	<select name="cc_expirationMonth" id="cc_expirationMonth" size="1">
            		<option value=""></option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                </select>&nbsp;/&nbsp;
	        	<select name="cc_expirationYear" id="cc_expirationYear" size="1">
            		<option value=""></option>';
	        
	        $year = date("Y");			
	        for ($i = 0; $i <= 20; $i++) 
	        	$html .='<option value="'.($year+$i).'">'.($year+$i).'</option>';
	        
	        $html .='
                </select>	
	        	</td></tr>';
			if(in_array("issueDate", $additionalFields)){
				$html .='
	        	<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"issueDate").'</td><td class="paymentrightcell" style="padding:5px;">
			       	<select name="cc_issueMonth" id="cc_issueMonth" size="1">
					        	<option value=""></option>
					        	<option value="01">01</option>
					        	<option value="02">02</option>
					        	<option value="03">03</option>
					        	<option value="04">04</option>
					        	<option value="05">05</option>
					        	<option value="06">06</option>
					        	<option value="07">07</option>
					        	<option value="08">08</option>
					        	<option value="09">09</option>
					        	<option value="10">10</option>
					        	<option value="11">11</option>
					        	<option value="12">12</option>
			       	</select>&nbsp;/&nbsp;
	        		<select name="cc_issueYear" id="cc_issueYear" size="1">
            			<option value=""></option>';
	        		        		
		        for ($j = 20; $j >= 0; $j--) 
		        	$html .='<option value="'.($year-$j).'">'.($year-$j).'</option>';
		        
		        $html .='
                	</select>	
	        	</td></tr>';          		
			}if(in_array("issueNumber", $additionalFields))
	            $html .= '<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"issueNumber").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="cc_issueNumber" autocomplete="off"></td></tr>';
			if(in_array("cardverifycode", $additionalFields))
				$html .= '<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"cardverifycode").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="cc_cardverifycode" autocomplete="off"></td></tr>';
			 
	       $html .= '<tr><td class="paymentleftcell" style="padding-right: 5px;"></td><td class="paymentrightcell" style="padding:5px;"><input type="button" id="dataStorageButton" value="'.LanguageManager::getLanguageEntry($this->system->languageCode,"storeData").'" onClick="storeData(\'CreditCard\');"></td></tr>';		
			
	       return $html;
		}else 
			MyLog::log("ATTENTION: Wrong PCI DSS SAQ configured: ".$GLOBALS["SESSION"]["wcsPaygate_pciDssSaq"], null) ;
			
		return "";
	}
	

	protected function getDataStoreCallbackJS(){	
		
		return '
				s += "anonymousPan: " + info.anonymousPan + "\n";
            s += "maskedPan: " + info.maskedPan + "\n";
            s += "financialInstitution: " + info.financialInstitution + "\n";
            s += "brand: " + info.brand + "\n";
            s += "cardholdername: " + info.cardholdername + "\n";
            s += "expiry: " + info.expiry + "\n";
            		';	
	}
}