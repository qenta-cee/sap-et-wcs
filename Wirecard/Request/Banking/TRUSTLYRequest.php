<?php

namespace WireCardSeamlessBundle\Wirecard\Request\Banking;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use WireCardSeamlessBundle\Wirecard\Request\WCBasicPaymentRequest;

class TRUSTLYRequest extends WCBasicPaymentRequest{
	
	/**
	 * Last name of consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 32
	 */
	protected $consumerBillingLastname;
	
	
	/**
	 * Billing country (ISO 3166-1).
	 * Within fingerprint: Required if used
	 * @var string Alphabetic with a fixed length of 2
	 */
	protected $consumerBillingCountry;
	
	
	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){
		$this->setConsumerBillingLastname($customer->lastName);
		$this->setConsumerBillingCountry($customer->nationality);		
		$this->setPendingUrl($this->getSuccessUrl());
	}
	
	
	public function getConsumerBillingLastname() {
		return $this->consumerBillingLastname;
	}
	public function setConsumerBillingLastname( $consumerBillingLastname) {
		$this->consumerBillingLastname = $consumerBillingLastname;
		return $this;
	}
	public function getConsumerBillingCountry() {
		return $this->consumerBillingCountry;
	}
	public function setConsumerBillingCountry( $consumerBillingCountry) {
		$this->consumerBillingCountry = $consumerBillingCountry;
		return $this;
	}
	
	
	
	
}