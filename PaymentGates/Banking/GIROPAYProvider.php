<?php

namespace WireCardSeamlessBundle\PaymentGates\Banking;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Banking\GIROPAYRequest;
use WireCardSeamlessBundle\Resources\Languages\LanguageManager;

class GIROPAYProvider extends PaymentProvider {

	static protected $paymentType = "GIROPAY";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new GIROPAYRequest();
	}

	protected function getSensitiveDataJS($configParams){
		return "
	          paymentInformation.accountOwner = document.getElementById('giropay_accountOwner').value;
	          paymentInformation.bankAccount = document.getElementById('giropay_bankAccount').value;
	          paymentInformation.bankNumber = document.getElementById('giropay_bankNumber').value;
	          // stores sensitive data to the Wirecard data storage
	          dataStorage.storeGiropayInformation(paymentInformation, callbackFunction);";
	}

	protected function getSensitiveDataHTMLFields($configParams){
		return '
			<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"accountOwner").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="giropay_accountOwner" autocomplete="off"></td></tr>
	      <tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"bankAccount").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="giropay_bankAccount" autocomplete="off"></td></tr>
	      <tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"bankNumber").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="giropay_bankNumber" autocomplete="off"></td></tr>
	      <tr><td class="paymentleftcell" style="padding-right: 5px;"></td><td class="paymentrightcell" style="padding:5px;"><input type="button" id="dataStorageButton" value="'.LanguageManager::getLanguageEntry($this->system->languageCode,"storeData").'" onClick="storeData(\'giropay\');"></td></tr>	
		';
	}

	protected function getDataStoreCallbackJS(){	
		
		return '
				s += "accountOwner: " + info.accountOwner + "\n";
            s += "bankAccount: " + info.bankAccount + "\n";
            s += "bankNumber: " + info.bankNumber + "\n";
            		';	
	}
	
	
}