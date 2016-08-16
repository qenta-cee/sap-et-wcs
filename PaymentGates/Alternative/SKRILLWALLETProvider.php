<?php 

namespace WireCardSeamlessBundle\PaymentGates\Alternative;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\SKRILLDWRequest;
use WireCardSeamlessBundle\Wirecard\WCResources;

class SKRILLWALLETProvider extends PaymentProvider{

	
	static protected $paymentType = "SKRILLWALLET";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new SKRILLDWRequest();
	}	
}


