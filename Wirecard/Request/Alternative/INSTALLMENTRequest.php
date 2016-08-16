<?php

namespace WireCardSeamlessBundle\Wirecard\Request\Alternative;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use WireCardSeamlessBundle\Wirecard\Request\WCBasicPaymentRequest;

class INSTALLMENTRequest extends WCBasicPaymentRequest {


	public function __construct(){
	
		//	To integrate and offer the payment methods invoice and installment to the consumers in your
		//	online shop you need to fulfill some important requirements:
		//		-	Both the currency of the shopping cart and the currency of the order amount have to be EUR.
		//		-	Your consumer must be older than 18 years of age.
		//		-	The order amount must not be below or exceed the limits as contractually agreed with payolution.
		//		-	All required consumer data must be available.
		//		-	Billing address and delivery address must be the same.
		//		-	Delivery country must be accepted by payolution.
		//		-	Additional parameters required by payolution for assessing the creditworthiness of your consumer must be submitted.
		//		-	Gift vouchers must be excluded and may not be purchased via invoice and installment.
	
		$this->currency = "EUR";
	
		//TODO: implement all requirements
	}
	
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
	
	/**
	 * Billing address line 1 (name of street and house number).
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 100
	 */
	protected $consumerBillingAddress1;
	
	/**
	 * Billing address line 2 (optionally the house number if not already set within consumerBillingAddress1).
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 100
	 */
	protected $consumerBillingAddress2;
	
	/**
	 * Billing city.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 32
	 */
	protected $consumerBillingCity;
	
	/**
	 * Billing country (ISO 3166-1).
	 * Within fingerprint: Required if used
	 * @var string Alphabetic with a fixed length of 2
	 */
	protected $consumerBillingCountry;
	
	/**
	 * Billing zip code.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 12
	 */
	protected $consumerBillingZipCode;
	
	/**
	 * E-mail address of consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with special characters and a variable length of up to 256
	 */
	protected $consumerEmail;
	
	/**
	 * Birth date of consumer in the format YYYY-MM-DD.
	 * Within fingerprint: Required if used
	 * @var string Numeric with special characters and a fixed length of 10
	 */
	protected $consumerBirthDate;
	
	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){
	
		//TODO: SETUP!
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
	public function getConsumerBillingAddress1() {
		return $this->consumerBillingAddress1;
	}
	public function setConsumerBillingAddress1( $consumerBillingAddress1) {
		$this->consumerBillingAddress1 = $consumerBillingAddress1;
		return $this;
	}
	public function getConsumerBillingAddress2() {
		return $this->consumerBillingAddress2;
	}
	public function setConsumerBillingAddress2( $consumerBillingAddress2) {
		$this->consumerBillingAddress2 = $consumerBillingAddress2;
		return $this;
	}
	public function getConsumerBillingCity() {
		return $this->consumerBillingCity;
	}
	public function setConsumerBillingCity( $consumerBillingCity) {
		$this->consumerBillingCity = $consumerBillingCity;
		return $this;
	}
	public function getConsumerBillingCountry() {
		return $this->consumerBillingCountry;
	}
	public function setConsumerBillingCountry( $consumerBillingCountry) {
		$this->consumerBillingCountry = $consumerBillingCountry;
		return $this;
	}
	public function getConsumerBillingZipCode() {
		return $this->consumerBillingZipCode;
	}
	public function setConsumerBillingZipCode( $consumerBillingZipCode) {
		$this->consumerBillingZipCode = $consumerBillingZipCode;
		return $this;
	}
	public function getConsumerEmail() {
		return $this->consumerEmail;
	}
	public function setConsumerEmail( $consumerEmail) {
		$this->consumerEmail = $consumerEmail;
		return $this;
	}
	public function getConsumerBirthDate() {
		return $this->consumerBirthDate;
	}
	public function setConsumerBirthDate( $consumerBirthDate) {
		$this->consumerBirthDate = $consumerBirthDate;
		return $this;
	}
	
		
}