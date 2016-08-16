<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Address
 * @package SAP\EventTicketing\DataExchangeObject\Customer
 *
 * @SapAssert\Postcode(field = "postalCode", message = "address.postalCode.postalCode")
 */
class Address
{
    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "address.id.type.integer")
     */
    public $id;

    /**
     * primary address
     * @var bool
     *
     * @Assert\Type(type = "bool", message = "address.primary.type.bool")
     */
    public $primary = false;

    /**
     * first name
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "address.firstName.length.min", maxMessage = "address.firstName.length.max")
     */
    public $firstName;

    /**
     * last name
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "address.lastName.length.min", maxMessage = "address.lastName.length.max")
     */
    public $lastName;

    /**
     * street
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "address.street.length.min", maxMessage = "address.street.length.max")
     */
    public $street;

    /**
     * street number
     * @var string
     *
     * @SapAssert\Length(max = 32, maxMessage = "address.streetNumber.length.max")
     */
    public $streetNumber;


    /**
     * postcode
     * @var string
     */
    public $postalCode;

    /**
     * city
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "address.city.length.min", maxMessage = "address.city.length.max")
     */
    public $city;

    /**
     * federal state
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "address.state.length.min", maxMessage = "address.state.length.max")
     */
    public $federalState = '';

    /**
     * country
     * @var string
     *
     * @Assert\Country(message = "address.country.country")
     */
    public $country;

    /**
     * salutation
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 50, minMessage = "address.salutation.length.min", maxMessage = "address.salutation.length.max")
     */
    public $salutation = '';

    /**
     * title
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "address.title.length.min", maxMessage = "address.title.length.max")
     */
    public $title = '';

    /**
     * external ID which is be known in all systems
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "address.externalId.length.min", maxMessage = "address.externalId.length.max")
     */
    public $externalId;

    /**
     * deleted or not
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "address.isDeleted.type.bool")
     */
    public $isDeleted = false;

    /**
     * company
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "address.company.length.min", maxMessage = "address.company.length.max")
     */
    public $company;

    /**
     * additional information
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "address.additionalInformation.length.max")
     */
    public $additionalInformation = '';
}
