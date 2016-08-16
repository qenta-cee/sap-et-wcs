<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

class Customer
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_LOCKED = 'LOCKED';

    const GENDER_FEMALE = 'FEMALE';
    const GENDER_MALE = 'MALE';

    /**
     * primary identifier
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "customer.id.length.max")
     */
    public $id;

    /**
     * customer number
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "customer.number.length.max")
     */
    public $number;

    /**
     * e-mail address
     * @var string
     *
     * @Assert\Email(message = "customer.email.email")
     */
    public $email;

    /**
     * password
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "customer.password.length.max")
     */
    public $password;

    /**
     * salutation
     * @var string
     *
     * @SapAssert\Length(max = 50, maxMessage = "customer.salutation.length.max")
     */
    public $salutation = '';

    /**
     * title
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "customer.title.length.max")
     */
    public $title = '';

    /**
     * first name
     * @var string
     *
     * @Assert\NotBlank(message = "customer.firstName.notBlank", groups = {"personalisation"})
     * @SapAssert\Length(min = 2, max = 255, minMessage = "customer.firstName.length.min", maxMessage = "customer.firstName.length.max")
     */
    public $firstName;

    /**
     * last name
     * @var string
     *
     * @Assert\NotBlank(message = "customer.lastName.notBlank", groups = {"personalisation"})
     * @SapAssert\Length(min = 2, max = 255, minMessage = "customer.lastName.length.min", maxMessage = "customer.lastName.length.max")
     */
    public $lastName;

    /**
     * language
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 20, minMessage = "customer.language.length.min", maxMessage = "customer.language.length.max")
     */
    public $language;

    /**
     * external customer number
     * @var string
     *
     * @SapAssert\Length(max = 34, maxMessage = "customer.externalNumber.length.max")
     */
    public $externalNumber = '';

    /**
     * company
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "customer.company.length.min", maxMessage = "customer.company.length.max")
     */
    public $company = '';

    /**
     * gender
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     "",
     *     Customer::GENDER_FEMALE,
     *     Customer::GENDER_MALE
     *   },
     *   message = "customer.gender.choice"
     * )
     */
    public $gender = '';

    /**
     * telephone number
     * @var string
     *
     * @SapAssert\PhoneNumber(message = "customer.phone.phoneNumber")
     */
    public $phone = '';

    /**
     * fax number
     * @var string
     *
     * @SapAssert\PhoneNumber(message = "customer.fax.phoneNumber")
     */
    public $fax = '';

    /**
     * mobile phone number
     * @var string
     *
     * @SapAssert\PhoneNumber(message = "customer.mobile.phoneNumber")
     */
    public $mobile = '';

    /**
     * nationality
     * @var string
     *
     * @Assert\Country(message = "customer.nationality.country")
     */
    public $nationality = '';

    /**
     * date of birth
     * @var string
     *
     * @SapAssert\Date(message = "customer.dateOfBirth.date")
     */
    public $dateOfBirth = '';

    /**
     * tax number
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "customer.taxNumber.length.min", maxMessage = "customer.taxNumber.length.max")
     */
    public $taxNumber = '';

    /**
     * passport number
     * @var string
     *
     * @SapAssert\Length(min = 2, max = 255, minMessage = "customer.passportNumber.length.min", maxMessage = "customer.passportNumber.length.max")
     */
    public $passportNumber = '';

    /**
     * status
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     Customer::STATUS_ACTIVE,
     *     Customer::STATUS_LOCKED
     *   },
     *   message = "customer.status.choice")
     */
    public $status;

    /**
     * business client
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "customer.businessclient.type.bool")
     */
    public $businessClient;

    /**
     * customer blocked
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "customer.isBlocked.type.bool")
     */
    public $isBlocked = false;

    /**
     * number of children
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "customer.children.type.integer")
     */
    public $children;
}
