<?php

namespace WireCardSeamlessBundle\Wirecard\Request\Banking;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use WireCardSeamlessBundle\Wirecard\Request\WCBasicPaymentRequest;

class PRZELEWY24Request extends WCBasicPaymentRequest{
	
	
	//For this payment method the following (otherwise optional) request parameter is required:
	
	/**
	 * E-mail address of consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with special characters and a variable length of up to 256
	 */
	protected $consumerEmail;
	
	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){		 
		$this->setConsumerEmail($customer->email);
	}
	
	public function getConsumerEmail() {
		return $this->consumerEmail;
	}
	public function setConsumerEmail( $consumerEmail) {
		$this->consumerEmail = $consumerEmail;
		return $this;
	}
	

	
}