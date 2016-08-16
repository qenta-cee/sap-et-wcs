<?php

namespace WireCardSeamlessBundle\PaymentGates\DirectDebit;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\DirectDebit\SEPAWCRequest;
use WireCardSeamlessBundle\Resources\Languages\LanguageManager;

class SEPADDProvider extends PaymentProvider {

	static protected $paymentType = "SEPA-DD";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new SEPAWCRequest();
	}
	
	protected function getSensitiveDataJS($configParams){
		return "
	          paymentInformation.bankBic = document.getElementById('sepa-dd_bankBic').value;
	          paymentInformation.bankAccountIban = document.getElementById('sepa-dd_bankAccountIban').value;
	          paymentInformation.accountOwner = document.getElementById('sepa-dd_accountOwner').value;
	          // stores sensitive data to the Wirecard data storage
	          dataStorage.storeSepaDdInformation(paymentInformation, callbackFunction);";
	}

	protected function getSensitiveDataHTMLFields($configParams){
		return '
			<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"accountOwner").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="sepa-dd_accountOwner" autocomplete="off"></td></tr>
	     	<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"bankAccountIban").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="sepa-dd_bankAccountIban" autocomplete="off"></td></tr>
	      	<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"bankBic").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="sepa-dd_bankBic" autocomplete="off"></td></tr>
	      	<tr><td class="paymentleftcell" style="padding-right: 5px;"></td><td class="paymentrightcell" style="padding:5px;"><input type="button" id="dataStorageButton" value="'.LanguageManager::getLanguageEntry($this->system->languageCode,"storeData").'" onClick="storeData(\'SEPA-DD\');"></td></tr>
		';
	}

	protected function getDataStoreCallbackJS(){	
		
		return '
				s += "bankBic: " + info.bankBic + "\n";
            s += "bankAccountIban: " + info.bankAccountIban + "\n";
            s += "accountOwner: " + info.accountOwner + "\n";
            		';	
	}
}