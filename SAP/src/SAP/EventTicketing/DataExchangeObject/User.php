<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * logged on user for invoices
 * @webserializable
 */
class User
{
    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "user.id.type.integer")
     */
    public $id;

    /**
     * username
     * @var string
     *
     * @SapAssert\Length(max = 64, maxMessage = "user.userName.length.max")
     */
    public $username;

    /**
     * real name of user
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "user.realName.length.max")
     */
    public $realName;

    /**
     * default region code
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "user.defaultRegion.length.max")
     */
    public $defaultRegion;

    /**
     * default category
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "user.defaultCategory.type.integer")
     */
    public $defaultCategory;

    /**
     * currency
     * @var string
     *
     * @SapAssert\Length(max = 1, maxMessage = "user.currency.length.max")
     */
    public $currency;

    /**
     * e-mail address
     * @var string
     *
     * @Assert\Email(message = "user.email.email")
     */
    public $email;
} 
