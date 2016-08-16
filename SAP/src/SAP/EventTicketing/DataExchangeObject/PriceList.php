<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Price list
 * @webserializable
 */
class PriceList
{
    const TYPE_DEFAULT = 'PRICE_LIST';
    const TYPE_SUBSCRIPTION = 'SUBSCRIPTION_PRICE_LIST';
    const TYPE_SUBSCRIPTION_THEATRE = 'THEATRE_SUBSCRIPTION_PRICE_LIST';
    const TYPE_SUBSCRIPTION_MIX = 'MIXED_SUBSCRIPTION_PRICE_LIST';
    const TYPE_EXTERNAL = 'EXTERNAL_PRICE_LIST';
    const TYPE_EXTERNAL_SUBSCRIPTION = 'EXTERNAL_SUBSCRIPTION_PRICE_LIST';
    const TYPE_EXTERNAL_SUBSCRIPTION_THEATRE = 'EXTERNAL_THEATRE_SUBSCRIPTION_PRICE_LIST';
    const TYPE_EXTERNAL_SUBSCRIPTION_MIX = 'EXTERNAL_MIXED_SUBSCRIPTION_PRICE_LIST';

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\NotBlank(message = "priceList.id.notBlank")
     * @Assert\Type(type = "integer", message = "priceList.id.type.integer")
     */
    public $id;

    /**
     * name
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "priceList.name.length.max")
     */
    public $name;

    /**
     * type
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *      PriceList::TYPE_DEFAULT,
     *      PriceList::TYPE_SUBSCRIPTION,
     *      PriceList::TYPE_SUBSCRIPTION_THEATRE,
     *      PriceList::TYPE_SUBSCRIPTION_MIX,
     *      PriceList::TYPE_EXTERNAL,
     *      PriceList::TYPE_EXTERNAL_SUBSCRIPTION,
     *      PriceList::TYPE_EXTERNAL_SUBSCRIPTION_THEATRE,
     *      PriceList::TYPE_EXTERNAL_SUBSCRIPTION_MIX
     *   },
     *   message = "priceList.type.choice"
     * )
     */
    public $type;

    /**
     * entries
     * @var PriceListEntryCollection=\SAP\EventTicketing\DataExchangeObject\PriceListEntry[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\PriceListEntryCollection",
     *   message = "priceList.priceListEntries.type.priceListEntryCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\PriceListEntry",
     *     message = "priceList.priceListEntries.all.type.priceListEntry"
     *   )
     * });
     * @Assert\Valid
     */
    public $priceListEntries;

    /**
     * @param $id integer Id of Price List
    */
    public function __construct($id)
    {
        $this->id = $id;
    }
}
