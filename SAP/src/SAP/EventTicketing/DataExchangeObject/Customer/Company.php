<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * pools with relations to customer
 * @webserializable
 */
class Company
{
    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "company.id.type.integer")
     */
    public $id;

    /**
     * full name of the company
     * @var string
     *
     * @SapAssert\Length(max = 150, maxMessage = "company.name.length.max")
     */
    public $name;

    /**
     * short name of the company
     * @var string
     *
     * @SapAssert\Length(max = 10, maxMessage = "company.shortName.length.max")
     */
    public $shortName;

    /**
     * subtitle of the company
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "company.subtitle.length.max")
     */
    public $subtitle;

    /**
     * ID of the company
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "company.companyId.type.integer")
     */
    public $companyId;

    /**
     * address of the company
     * @var \SAP\EventTicketing\DataExchangeObject\Customer\Address
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Customer\Address", message = "company.address.type.address")
     * @Assert\Valid
     */
    public $address;

    /**
     * billing address
     * @var string
     *
     * @SapAssert\Length(max = 512, maxMessage = "company.billingAddress.length.max")
     */
    public $billingAddress;

    /**
     * email address
     * @var string
     *
     * @Assert\Email(message = "company.email.email")
     */
    public $email;

    /**
     * phone number
     * @var string
     *
     * @SapAssert\PhoneNumber(message = "company.phone.phoneNumber")
     */
    public $phone;

    /**
     * fax number
     * @var string
     *
     * @SapAssert\PhoneNumber(message = "company.fax.phoneNumber")
     */
    public $fax;

    /**
     * creditor ID
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "company.creditorId.type.integer")
     */
    public $creditorId;

    /**
     * used payment method
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "company.methodOfPayment.length.max")
     */
    public $methodOfPayment;

    /**
     * value if company is locked
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "company.isBlocked.type.bool")
     */
    public $isBlocked;

    /**
     * value to identify if the company is also organizer
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "company.isOrganizer.type.bool")
     */
    public $isOrganizer;

    /**
     * value to identify if the company is also advance booking office
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "company.isAdvanceBookingOffice.type.bool")
     */
    public $isAdvanceBookingOffice;

    /**
     * value to identify if the company is also operator of the arena/stadium
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "company.isVenueOwner.type.bool")
     */
    public $isVenueOwner;
}
