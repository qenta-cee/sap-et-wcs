<?php

namespace WireCardSeamlessBundle\PaymentGates\Voucher;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\WCResources;
use WireCardSeamlessBundle\Wirecard\Request\Voucher\VOUCHERRequest;
use WireCardSeamlessBundle\Resources\Languages\LanguageManager;

class VOUCHERProvider extends PaymentProvider {

	static protected $paymentType = "VOUCHER";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new VOUCHERRequest();
	}

	protected function getSensitiveDataJS($configParams){
		return "
	          paymentInformation.voucherId = document.getElementById('voucherId').value;
	          // stores sensitive data to the Wirecard data storage
	          dataStorage.storeVoucherInformation(paymentInformation, callbackFunction);";
	}

	protected function getSensitiveDataHTMLFields($configParams){
		return '
			<tr><td class="paymentleftcell" style="padding-right: 5px;">'.LanguageManager::getLanguageEntry($this->system->languageCode,"voucherId").'</td><td class="paymentrightcell" style="padding:5px;"><input type="text" value="" id="voucherId" autocomplete="off"></td></tr>
	      <tr><td class="paymentleftcell" style="padding-right: 5px;"></td><td class="paymentrightcell" style="padding:5px;"><input type="button" id="dataStorageButton" value="'.LanguageManager::getLanguageEntry($this->system->languageCode,"storeData").'" onClick="storeData(\'voucher\');"></td></tr>	
		';
	}

	protected function getDataStoreCallbackJS(){	
		
		return '
				s += "voucherId: " + info.voucherId + "\n";
            		';	
	}
}