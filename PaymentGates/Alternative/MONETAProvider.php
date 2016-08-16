<?php 

namespace WireCardSeamlessBundle\PaymentGates\Alternative;

use WireCardSeamlessBundle\PaymentProvider;
use WireCardSeamlessBundle\Wirecard\Request\Alternative\MONETARURequest;
use WireCardSeamlessBundle\Wirecard\WCResources;

class MONETAProvider extends PaymentProvider{

	
	static protected $paymentType = "MONETA";
	
	protected function createRequestObject(){
		$this->paymentRequestObject = new MONETARURequest();
	}	
}


