<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Article
 * @webserializable
 */
class Article
{
    /**
     * primary identifier
     * @var integer
     *
     * @Assert\NotBlank(message = "article.id.notBlank")
     * @Assert\Type(type = "integer", message = "article.id.type.integer")
     */
    public $id;

    /**
     * name of article
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "article.name.length.max")
     */
    public $name;

    /**
     * description text of an article
     * @var string
     *
     * @SapAssert\Length(max = 65000, maxMessage = "article.description.length.max")
     */
    public $description;

    /**
     * article number
     * @var string
     *
     * @SapAssert\Length(max = 30, maxMessage = "article.number.length.max")
     */
    public $number;

    /**
     * ean number
     * @var string
     *
     * @SapAssert\Length(max = 40, maxMessage = "article.ean.length.max")
     */
    public $ean;

    /**
     * price category
     * @var \SAP\EventTicketing\DataExchangeObject\PriceCategory
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\PriceCategory", message = "priceCategory.priceCategory.type.PriceCategory")
     * @Assert\Valid
     */
    public $priceCategory;

    /**
     * price
     * @var \SAP\EventTicketing\DataExchangeObject\Price
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Price", message = "Price.price.type.price")
     * @Assert\Valid
     */
    public $price;

    /**
     * @param $id int Article Id
     */
    function __construct($id)
    {
        $this->id = $id;
    }
} 
