<?php
namespace SAP\EventTicketing\DataExchangeObject;

use SAP\EventTicketing\DataExchangeObject\Customer\AddressCollection;
use SAP\EventTicketing\DataExchangeObject\Customer\BankAccountCollection;
use SAP\EventTicketing\DataExchangeObject\Customer\BlockingCollection;
use SAP\EventTicketing\DataExchangeObject\Customer\CompanyCollection;
use SAP\EventTicketing\DataExchangeObject\Customer\CommunicationCollection;
use SAP\EventTicketing\DataExchangeObject\Customer\MarketingConsentCollection;
use SAP\EventTicketing\DataExchangeObject\Customer\SepaMandateCollection;
use SAP\EventTicketing\DataExchangeObject\Customer\CustomerPoolCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * export customer
 *
 * @webserializable
 */
class ExportCustomer
{
    /**
     * @var \SAP\EventTicketing\DataExchangeObject\Customer
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer",
     *   message = "exportCustomer.customer.type.customer"
     * )
     * @Assert\Valid
     */
    public $customer;

    /**
     * @var AddressCollection=\SAP\EventTicketing\DataExchangeObject\Customer\Address[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\AddressCollection",
     *   message = "exportCustomer.addresses.type.addressCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\Address",
     *     message = "exportCustomer.addresses.all.type.address"
     *   )
     * })
     * @Assert\Valid
     */
    public $addresses;

    /**
     * @var BlockingCollection=\SAP\EventTicketing\DataExchangeObject\Customer\Blocking[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\BlockingCollection",
     *   message = "exportCustomer.blockings.type.blockingCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\Blocking",
     *     message = "exportCustomer.blockings.all.type.blocking"
     *   )
     * })
     * @Assert\Valid
     */
    public $blockings;

    /**
     * @var CommunicationCollection=\SAP\EventTicketing\DataExchangeObject\Customer\Communication[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\CommunicationCollection",
     *   message = "exportCustomer.communications.type.communicationCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\Communication",
     *     message = "exportCustomer.communications.all.type.communication"
     *   )
     * })
     * @Assert\Valid
     */
    public $communications;

    /**
     * @var CompanyCollection=\SAP\EventTicketing\DataExchangeObject\Customer\Company[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\CompanyCollection",
     *   message = "exportCustomer.companies.type.companyCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\Company",
     *     message = "exportCustomer.companies.all.type.company"
     *   )
     * })
     * @Assert\Valid
     */
    public $companies;

    /**
     * @var CustomerPoolCollection=\SAP\EventTicketing\DataExchangeObject\Customer\CustomerPool[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\CustomerPoolCollection",
     *   message = "exportCustomer.customerPools.type.customerPoolCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\CustomerPool",
     *     message = "exportCustomer.customerPools.all.type.customerPool"
     *   )
     * })
     * @Assert\Valid
     */
    public $customerPools;

    /**
     * @var SepaMandateCollection=\SAP\EventTicketing\DataExchangeObject\Customer\SepaMandate[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\SepaMandateCollection",
     *   message = "exportCustomer.sepaMandates.type.sepaMandateCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\SepaMandate",
     *     message = "exportCustomer.sepaMandates.all.type.sepaMandate"
     *   )
     * })
     * @Assert\Valid
     */
    public $sepaMandates;

    /**
     * @var bankAccountCollection=\SAP\EventTicketing\DataExchangeObject\Customer\BankAccount[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\BankAccountCollection",
     *   message = "exportCustomer.bankAccounts.type.bankAccountCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\BankAccount",
     *     message = "exportCustomer.bankAccounts.all.type.bankAccount"
     *   )
     * })
     * @Assert\Valid
     */
    public $bankAccounts;

    /**
     * @var marketingConsentCollection=\SAP\EventTicketing\DataExchangeObject\Customer\MarketingConsent[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\MarketingConsentCollection",
     *   message = "exportCustomer.marketingConsents.type.marketingConsentCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Customer\MarketingConsent",
     *     message = "exportCustomer.marketingConsents.all.type.marketingConsent"
     *   )
     * })
     * @Assert\Valid
     */
    public $marketingConsents;

    /**
     * @var \SAP\EventTicketing\DataExchangeObject\Customer\Duplicate
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\Duplicate",
     *   message = "exportCustomer.customerDuplicate.type.customer"
     * )
     * @Assert\Valid
     */
    public $customerDuplicate;

    public function __construct()
    {
        $this->addresses = new AddressCollection();
        $this->blockings = new BlockingCollection();
        $this->communications = new CommunicationCollection();
        $this->companies = new CompanyCollection();
        $this->customerPools = new CustomerPoolCollection();
        $this->sepaMandates = new SepaMandateCollection();
        $this->bankAccounts = new BankAccountCollection();
        $this->marketingConsents = new MarketingConsentCollection();
    }
}
