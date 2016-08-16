<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Charge
 * @webserializable
 */
class Charge
{
    const TYPE_BASIC = 'BASIC';
    const TYPE_SYSTEM = 'SYSTEM';
    const TYPE_PRESALE = 'PRESALE';
    const TYPE_OTHER = 'OTHER';

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "int", message = "charge.id.type.integer")
     */
    public $id;

    /**
     * alias
     * @var string
     *
     * @Assert\NotBlank(message = "charge.key.notBlank")
     * @SapAssert\Length(max = 4, maxMessage = "charge.key.length.max")
     */
    public $key;

    /**
     * name
     * @var string
     *
     * @Assert\NotBlank(message = "charge.name.notBlank")
     * @SapAssert\Length(max = 255, maxMessage = "charge.name.length.max")
     */
    public $name;

    /**
     * type
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     Charge::TYPE_BASIC,
     *     Charge::TYPE_SYSTEM,
     *     Charge::TYPE_PRESALE,
     *     Charge::TYPE_OTHER
     *   },
     *   message = "charge.type.choice"
     * )
     */
    public $type;

    /**
     * value added tax
     * @var double
     *
     * @Assert\Type(type = "double", message = "charge.vat.type.double")
     */
    public $vat;

    /**
     * absolute price
     * @var \SAP\EventTicketing\DataExchangeObject\Price
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Price", message = "charge.absolute.type.price")
     * @Assert\Valid
     */
    public $absolute;

    /**
     * relative value of invoice
     * @var double
     *
     * @Assert\Type(type = "double", message = "charge.relative.type.double")
     */
    public $relative;

    /**
     * print text
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "charge.printText.length.max")
     */
    public $printText;

    public function __construct($key, $name)
    {
        $this->key = $key;
        $this->name = $name;
    }
}
