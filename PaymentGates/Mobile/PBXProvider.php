<?php

namespace WireCardSeamlessBundle\PaymentGates\Mobile;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Mobile\PBXRequest;
use WireCardSeamlessBundle\Resources\Languages\LanguageManager;

class PBXProvider extends PaymentProvider {

	static protected $paymentType = "PBX";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new PBXRequest();
	}
	
	protected function getSensitiveDataJS($configParams){
		return "
	          paymentInformation.payerPayboxNumber = document.getElementById('payerPayboxNumber').value;
	          // stores sensitive data to the Wirecard data storage
	          dataStorage.storePayboxInformation(paymentInformation, callbackFunction);";
	}

	protected function getSensitiveDataHTMLFields($configParams){
		return '
			<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"payerPayboxNumber").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="payerPayboxNumber" autocomplete="off"></td></tr>
      		<tr><td class="paymentleftcell" style="padding-right: 5px;"></td><td class="paymentrightcell" style="padding:5px;"><input type="button" id="dataStorageButton" value="'.LanguageManager::getLanguageEntry($this->system->languageCode,"storeData").'" onClick="storeData(\'paybox\');"></td></tr>	
		';
	}

	protected function getDataStoreCallbackJS(){	
		
		return '
				s += "payerPayboxNumber: " + info.payerPayboxNumber + "\n";
            		';	
	}
	
}