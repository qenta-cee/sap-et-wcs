<?php

namespace SAP\EventTicketing\DataExchangeObject;

use SAP\EventTicketing\DataExchangeObject;
use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * ExtraPrice
 * @package SAP\EventTicketing\DataExchangeObject
 */
class ExtraPrice
{
    const TYPE_ABSOLUT_PRICE_TO_SINGLE_VALUE = 'ABSOLUT_PRICE_TO_SINGLE_VALUE';
    const TYPE_A_PERCENTAGE_OF_THE_TOTAL = 'A_PERCENTAGE_OF_THE_TOTAL';
    const TYPE_ABSOLUTE_COST_OF_THE_TOTAL = 'ABSOLUTE_COST_OF_THE_TOTAL';
    const TYPE_COMMENT_NOTE_ABSOLUTE_COST_OF_THE_TOTAL = 'COMMENT_NOTE_ABSOLUTE_COST_OF_THE_TOTAL';
    const TYPE_MULTIPLE_SELECTOR_BUTTON_ABSOLUTE_COST_OF_THE_TOTAL = 'MULTIPLE_SELECTOR_BUTTON_ABSOLUTE_COST_OF_THE_TOTAL';
    const TYPE_CANCELLATION_FEE_ABSOLUTE = 'CANCELLATION_FEE_ABSOLUTE';
    const TYPE_CANCELLATION_FEE_RELATIVELY = 'CANCELLATION_FEE_RELATIVELY';
    const TYPE_RESALE_FEE_ABSOLUTE = 'RESALE_FEE_ABSOLUTE';
    const TYPE_RESALE_FEE_RELATIVELY = 'RESALE_FEE_RELATIVELY';
    const SURCHARGE_SURCHARGE = 'SURCHARGE';
    const SURCHARGE_DISCOUNT = 'DISCOUNT';

    /**
     * primary identifier
     * @var integer
     * 
     * @Assert\Type(type = "integer" , message = "extraPrice.id.type.integer")
     */
    public $id;

    /**
     * name
     * @var string
     *
     * @SapAssert\Length(max=255, maxMessage = "extraPrice.name.length.max")
     */
    public $name;

    /**
     * absolute price
     * @var Price
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Price", message = "extraPrice.absolute.type.price")
     * @Assert\Valid
     */
    public $absolute;

    /**
     * relative value of invoice
     * @var double
     *
     * @Assert\Type(type = "double", message = "extraPrice.relative.type.double")
     */
    public $relative;

    /**
     * value added tax
     * @var double
     *
     * @Assert\Type(type = "double", message = "extraPrice.vat.type.double")
     */
    public $vat;

    /**
     * type
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *      ExtraPrice::TYPE_ABSOLUT_PRICE_TO_SINGLE_VALUE,
     *      ExtraPrice::TYPE_A_PERCENTAGE_OF_THE_TOTAL,
     *      ExtraPrice::TYPE_ABSOLUTE_COST_OF_THE_TOTAL,
     *      ExtraPrice::TYPE_COMMENT_NOTE_ABSOLUTE_COST_OF_THE_TOTAL,
     *      ExtraPrice::TYPE_MULTIPLE_SELECTOR_BUTTON_ABSOLUTE_COST_OF_THE_TOTAL,
     *      ExtraPrice::TYPE_CANCELLATION_FEE_ABSOLUTE,
     *      ExtraPrice::TYPE_CANCELLATION_FEE_RELATIVELY,
     *      ExtraPrice::TYPE_RESALE_FEE_ABSOLUTE,
     *      ExtraPrice::TYPE_RESALE_FEE_RELATIVELY
     *   },
     *   message = "extraPrice.type.choice"
     * )
     */
    public $type = self::TYPE_ABSOLUT_PRICE_TO_SINGLE_VALUE;

    /**
     * surcharge
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *      ExtraPrice::SURCHARGE_SURCHARGE,
     *      ExtraPrice::SURCHARGE_DISCOUNT
     *   },
     *   message = "extraPrice.surcharge.choice"
     * )
     */
    public $surcharge = self::SURCHARGE_SURCHARGE;

    /**
     * flag for shipping or extra price
     * @var bool
     *
     * @Assert\Type(type = "bool", message = "extraPrice.shipping.type.bool")
     */
    public $shipping = false;
}
