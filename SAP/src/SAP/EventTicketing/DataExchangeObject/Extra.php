<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

class Extra {

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "extra.id.type.integer")
     */
    public $id;

    /**
     * name
     * @var string
     *
     * @SapAssert\Length(max = 256, maxMessage = "extra.name.length.max")
     */
    public $name;

    /**
     * value added tax
     * @var double
     *
     * @Assert\Type(type = "double", message = "extra.vat.type.double")
     */
    public $vat;

    /**
     * collection of prices
     * @var CostCollection=\SAP\EventTicketing\DataExchangeObject\Cost[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\CostCollection",
     *   message = "extra.prices.type.costCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Cost",
     *     message = "extra.prices.all.type.cost"
     *   )
     * })
     * @Assert\Valid
     */
    public $prices;

    /**
     * price identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "extra.priceId.type.integer")
     */
    public $priceId;

    public function __construct(){
        $this->prices = new CostCollection();
    }
}
