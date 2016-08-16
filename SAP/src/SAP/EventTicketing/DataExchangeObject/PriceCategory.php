<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * category of a price
 * @webserializable
 */
class PriceCategory
{
    /**
     * identifier
     * @var integer
     *
     * @Assert\NotBlank(message = "priceCategory.id.notBlank")
     * @Assert\Type(type = "integer", message = "priceCategory.id.type.integer")
     */
    public $id;

    /**
     * name
     * @var string
     *
     * @Assert\NotBlank(message = "priceCategory.name.notBlank")
     * @SapAssert\Length(max = 255, maxMessage = "priceCategory.name.length.max")
     */
    public $name;

    /**
     * @param $name
     * @param $id
     */
    function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
} 
