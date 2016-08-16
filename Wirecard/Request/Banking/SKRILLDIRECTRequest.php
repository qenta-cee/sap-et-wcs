<?php

namespace WireCardSeamlessBundle\Wirecard\Request\Banking;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use WireCardSeamlessBundle\Wirecard\Request\WCBasicPaymentRequest;

class SKRILLDIRECTRequest extends WCBasicPaymentRequest {
	/**
	 * First name of consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 32
	 */
	protected $consumerBillingFirstname;
	
	/**
	 * Last name of consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 32
	 */
	protected $consumerBillingLastname;

	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){

		$this->setConsumerBillingFirstname($customer->firstName);
		$this->setConsumerBillingLastname($customer->lastName);
	}
	
	public function getConsumerBillingFirstname() {
		return $this->consumerBillingFirstname;
	}
	public function setConsumerBillingFirstname( $consumerBillingFirstname) {
		$this->consumerBillingFirstname = $consumerBillingFirstname;
		return $this;
	}
	public function getConsumerBillingLastname() {
		return $this->consumerBillingLastname;
	}
	public function setConsumerBillingLastname( $consumerBillingLastname) {
		$this->consumerBillingLastname = $consumerBillingLastname;
		return $this;
	}
	
	
	
}