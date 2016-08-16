<?php

namespace WireCardSeamlessBundle\Wirecard\Request\Cards;

use Psr\Log\LoggerInterface;
use SAP\EventTicketing\Bundle\PaymentBundle\Model\DialogData;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer;
use WireCardSeamlessBundle\Wirecard\Request\WCBasicPaymentRequest;

class CCARDRequest extends WCBasicPaymentRequest{
	
	public function setupSpecificParameters(DialogData $dialogData, PaymentTransaction $transaction, Company $company, Customer $customer){	
	
	}	
	

	//	for usage of American Express Address Verification - Amex AVS 
	// 	NOT SUPPORTED yet! Because SAPET does no yet deliver the needed data
	
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
	
	/**
	 * Phone number of consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 20
	 */
	protected $consumerBillingPhone;
	
	/**
	 * Fax number of consumer.
	 * Within fingerprint: Required if used
	 * @var string Alphanumeric with a variable length of up to 20
	 */
	protected $consumerBillingFax;
	
		
	public function getConsumerBillingFirstname() {
		return $this->consumerBillingFirstname;
	}
	public function setConsumerBillingFirstname($consumerBillingFirstname) {
		$this->consumerBillingFirstname = $consumerBillingFirstname;
		return $this;
	}
	public function getConsumerBillingLastname() {
		return $this->consumerBillingLastname;
	}
	public function setConsumerBillingLastname($consumerBillingLastname) {
		$this->consumerBillingLastname = $consumerBillingLastname;
		return $this;
	}
	public function getConsumerBillingAddress1() {
		return $this->consumerBillingAddress1;
	}
	public function setConsumerBillingAddress1($consumerBillingAddress1) {
		$this->consumerBillingAddress1 = $consumerBillingAddress1;
		return $this;
	}
	public function getConsumerBillingAddress2() {
		return $this->consumerBillingAddress2;
	}
	public function setConsumerBillingAddress2($consumerBillingAddress2) {
		$this->consumerBillingAddress2 = $consumerBillingAddress2;
		return $this;
	}
	public function getConsumerBillingCity() {
		return $this->consumerBillingCity;
	}
	public function setConsumerBillingCity($consumerBillingCity) {
		$this->consumerBillingCity = $consumerBillingCity;
		return $this;
	}
	public function getConsumerBillingCountry() {
		return $this->consumerBillingCountry;
	}
	public function setConsumerBillingCountry($consumerBillingCountry) {
		$this->consumerBillingCountry = $consumerBillingCountry;
		return $this;
	}
	public function getConsumerBillingZipCode() {
		return $this->consumerBillingZipCode;
	}
	public function setConsumerBillingZipCode($consumerBillingZipCode) {
		$this->consumerBillingZipCode = $consumerBillingZipCode;
		return $this;
	}
	public function getConsumerEmail() {
		return $this->consumerEmail;
	}
	public function setConsumerEmail($consumerEmail) {
		$this->consumerEmail = $consumerEmail;
		return $this;
	}
	public function getConsumerBirthDate() {
		return $this->consumerBirthDate;
	}
	public function setConsumerBirthDate($consumerBirthDate) {
		$this->consumerBirthDate = $consumerBirthDate;
		return $this;
	}
	public function getConsumerBillingPhone() {
		return $this->consumerBillingPhone;
	}
	public function setConsumerBillingPhone($consumerBillingPhone) {
		$this->consumerBillingPhone = $consumerBillingPhone;
		return $this;
	}
	public function getConsumerBillingFax() {
		return $this->consumerBillingFax;
	}
	public function setConsumerBillingFax($consumerBillingFax) {
		$this->consumerBillingFax = $consumerBillingFax;
		return $this;
	}
	
}