<?php

namespace WireCardSeamlessBundle\Wirecard\Request\Alternative;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use WireCardSeamlessBundle\Wirecard\Request\WCBasicPaymentRequest;

class PAYPALRequest extends WCBasicPaymentRequest {
	
	
	// CONSUMER SHIPPING DATA
	// If you would like to use PayPal Seller-Protection the following parameters are required, otherwise they are optional.
	
	/**
	 * First name of consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 32
	 */
	protected $consumerShippingFirstName;
	
	/**
	 * Last name of consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 32
	 */
	protected $consumerShippingLastName;
	
	/**
	 * Shipping address line 1.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 100
	 */
	protected $consumerShippingAddress1;
	
	/**
	 * Shipping address line 2.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 100
	 */
//	protected $consumerShippingAddress2;
	
	/**
	 * Shipping city.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 32
	 */
	protected $consumerShippingCity;
	
	/**
	 * Shipping state.
	 * Within fingerprint: Required if used
	 * @var string Alphabetic with a fixed length of 2
	 */
	protected $consumerShippingState;

	/**
	 * Shipping country code.
	 * Within fingerprint: Required if used
	 * @var string Alphabetic with a fixed length of 2
	 */
	protected $consumerShippingCountry;
	
	/**
	 * Shipping zip code.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 12
	 */
	protected $consumerShippingZipCode;
	
	/**
	 * Shipping phone number.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 20
	 */
//	protected $consumerShippingPhone;
	
	/**
	 * Shipping fax number.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 20
	 */
//	protected $consumerShippingFax;
	
	
	
	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){
		 	
		//DONE: for SELLER PROTECTION: some data is missing in the Customer class (billing adress,..). or use Company? --- SAPET delivers no basket data -> no SELLER PROTECTION
	}
	public function getConsumerShippingFirstName() {
		return $this->consumerShippingFirstName;
	}
	public function setConsumerShippingFirstName( $consumerShippingFirstName) {
		$this->consumerShippingFirstName = $consumerShippingFirstName;
		return $this;
	}
	public function getConsumerShippingLastName() {
		return $this->consumerShippingLastName;
	}
	public function setConsumerShippingLastName( $consumerShippingLastName) {
		$this->consumerShippingLastName = $consumerShippingLastName;
		return $this;
	}
	public function getConsumerShippingAddress1() {
		return $this->consumerShippingAddress1;
	}
	public function setConsumerShippingAddress1( $consumerShippingAddress1) {
		$this->consumerShippingAddress1 = $consumerShippingAddress1;
		return $this;
	}
	public function getConsumerShippingCity() {
		return $this->consumerShippingCity;
	}
	public function setConsumerShippingCity( $consumerShippingCity) {
		$this->consumerShippingCity = $consumerShippingCity;
		return $this;
	}
	public function getConsumerShippingState() {
		return $this->consumerShippingState;
	}
	public function setConsumerShippingState( $consumerShippingState) {
		$this->consumerShippingState = $consumerShippingState;
		return $this;
	}
	public function getConsumerShippingCountry() {
		return $this->consumerShippingCountry;
	}
	public function setConsumerShippingCountry( $consumerShippingCountry) {
		$this->consumerShippingCountry = $consumerShippingCountry;
		return $this;
	}
	public function getConsumerShippingZipCode() {
		return $this->consumerShippingZipCode;
	}
	public function setConsumerShippingZipCode( $consumerShippingZipCode) {
		$this->consumerShippingZipCode = $consumerShippingZipCode;
		return $this;
	}
	
	
	
	
	
}