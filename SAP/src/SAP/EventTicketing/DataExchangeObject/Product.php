<?php
namespace SAP\EventTicketing\DataExchangeObject;

use SAP\EventTicketing\DataExchangeObject\CostCollection;
use SAP\EventTicketing\DataExchangeObject\ChargeCollection;
use SAP\EventTicketing\DataExchangeObject\InvoiceReferenceCollection;
use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * product
 * @webserializable
 */
class Product
{
    const STATE_RESERVED = 'RESERVED';
    const STATE_RETURNED = 'RETURNED';
    const STATE_ORDERED = 'ORDERED';

    /**
     * primary identifier
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "product.id.length.max")
     */
    public $id;

    /**
     * barcode
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "product.barcode.length.max")
     */
    public $barcode;

    /**
     * rfid
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "product.rfid.length.max")
     */
    public $rfid;

    /**
     * Old rfid values from the history
     * @var string[]
     *
     * @SapAssert\Length(max = 20, maxMessage = "product.rfidOld.length.max")
     */
    public $rfidOld;

    /**
     * state
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     Product::STATE_RESERVED,
     *     Product::STATE_RETURNED,
     *     Product::STATE_ORDERED
     *   },
     *   message = "product.state.choice"
     * )
     */
    public $state;

    /**
     * row
     * @var string
     *
     * @SapAssert\Length(max = 10, maxMessage = "product.row.length.max")
     */
    public $row;

    /**
     * seat
     * @var string
     *
     * @SapAssert\Length(max = 256, maxMessage = "product.seat.length.max")
     */
    public $seat;

    /**
     * block object
     * @var \SAP\EventTicketing\DataExchangeObject\Block
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Block", message = "product.block.type.block")
     * @Assert\Valid
     */
    public $block;

    /**
     * performance object
     * @var \SAP\EventTicketing\DataExchangeObject\Performance
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Performance", message = "product.performance.type.performance")
     * @Assert\Valid
     */
    public $performance;

    /**
     * expenses
     * @var CostCollection=\SAP\EventTicketing\DataExchangeObject\Cost[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\CostCollection",
     *   message = "product.expenses.type.costCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Cost",
     *     message = "product.expenses.all.type.cost"
     *   )
     * })
     * @Assert\Valid
     */
    public $expenses;

    /**
     * customer object
     * @var \SAP\EventTicketing\DataExchangeObject\Customer
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Customer", message = "product.customer.type.customer")
     * @Assert\Valid
     */
    public $customer;

    /**
     * owner object
     * @var \SAP\EventTicketing\DataExchangeObject\Owner
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Owner", message = "product.owner.type.owner")
     * @Assert\Valid
     */
    public $owner;

    /**
     * valid from date
     * @var string
     *
     * @SapAssert\Date(message = "product.validDate.date")
     */
    public $validDate;

    /**
     * valid from time
     * @var string
     *
     * @SapAssert\Time(message = "product.validTimeBegin.time")
     */
    public $validTimeBegin;

    /**
     * valid until time
     * @var string
     *
     * @SapAssert\Time(message = "product.validTimeEnd.time")
     */
    public $validTimeEnd;

    /**
     * print info object
     * @var \SAP\EventTicketing\DataExchangeObject\PrintInfo
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\PrintInfo",
     *   message = "product.printInfo.type.printInfo"
     * )
     * @Assert\Valid
     */
    public $printInfo;

    /**
     * price reductions
     * @var ChargeCollection=\SAP\EventTicketing\DataExchangeObject\Charge[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\ChargeCollection",
     *   message = "product.reductions.type.chargeCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Charge",
     *     message = "product.reductions.all.type.charge"
     *   )
     * });
     * @Assert\Valid
     */
    public $reductions;

    /**
     * price category object
     * @var \SAP\EventTicketing\DataExchangeObject\PriceCategory
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\PriceCategory",
     *   message = "product.priceCategory.type.priceCategory"
     * )
     * @Assert\Valid
     */
    public $priceCategory;

    /**
     * invoice objects
     * @var InvoiceReferenceCollection=\SAP\EventTicketing\DataExchangeObject\InvoiceReference[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\InvoiceReferenceCollection",
     *   message = "product.invoiceReferences.type.invoiceReferenceCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\InvoiceReference",
     *     message = "product.invoiceReferences.all.type.invoiceReference"
     *   )
     * });
     * @Assert\Valid
     */
    public $invoiceReferences;

    /**
     * If Product is an article the article number is set
     * @var string
     *
     * @SapAssert\Length(max = 30, maxMessage = "product.articleNumber.length.max")
     */
    public $articleNumber;

    /**
     * If Product is an article the EAN is set
     * @var string
     *
     * @SapAssert\Length(max = 40, maxMessage = "product.ean.length.max")
     */
    public $ean;

    public function __construct()
    {
        $this->expenses = new CostCollection();
        $this->invoiceReferences = new InvoiceReferenceCollection();
        $this->reductions = new ChargeCollection();
    }
}
