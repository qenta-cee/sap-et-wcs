<?php 

namespace WireCardSeamlessBundle\PaymentGates\Alternative;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\PAYSAFECARDRequest;
use WireCardSeamlessBundle\Wirecard\WCResources;

class PSCProvider extends PaymentProvider{

	
	static protected $paymentType = "PSC";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new PAYSAFECARDRequest();
	}	
}


