<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Price list entry
 * @webserializable
 */
class PriceListEntry
{
    /**
     * price identifier
     * @var integer
     *
     * @Assert\NotBlank(message = "priceListEntry.priceId.notBlank")
     * @Assert\Type(type = "integer", message = "priceListEntry.priceId.type.integer")
     */
    public $priceId;

    /**
     * category
     * @var string
     *
     * @Assert\NotBlank(message = "priceListEntry.category.notBlank")
     * @SapAssert\Length(max = 255, maxMessage = "priceListEntry.category.length.max")
     */
    public $category;

    /**
     * reduction identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "priceListEntry.reductionId.type.integer")
     */
    public $reductionId;

    /**
     * reduction name
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "priceListEntry.reductionName.length.max")
     */
    public $reductionName;

    /**
     * price
     * @var \SAP\EventTicketing\DataExchangeObject\Price
     *
     * @Assert\NotBlank(message = "charge.key.notBlank")
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Price", message = "priceListEntry.price.type.price")
     * @Assert\Valid
     */
    public $price;

    public function __construct($priceId, $category, Price $price)
    {
        $this->priceId = $priceId;
        $this->category = $category;
        $this->price = $price;
    }
}
