<?php
namespace SAP\EventTicketing\DataExchangeObject;

use SAP\EventTicketing\DataExchangeObject\ProductCollection;
use SAP\EventTicketing\DataExchangeObject\CostCollection;
use SAP\EventTicketing\DataExchangeObject\Customer\Company;
use SAP\EventTicketing\DataExchangeObject\Customer\Address;
use SAP\EventTicketing\DataExchangeObject\InvoicePayment;
use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * @webserializable
 */
class Invoice
{
    const TYPE_MONEY_TRANSFER = 'MONEY_TRANSFER';
    const TYPE_ORGANIZER_INVOICE = 'ORGANIZER_INVOICE';
    const TYPE_CONCLUSION = 'CONCLUSION';
    const TYPE_PRESALE_INVOICE = 'PRESALE_INVOICE';
    const TYPE_OPTION = 'OPTION';
    const TYPE_RETURN = 'RETURN';
    const TYPE_INVOICE = 'INVOICE';

    /**
     * primary identifier
     * @var string
     *
     * @SapAssert\Length(max=20, maxMessage = "invoice.id.length.max")
     */
    public $id;

    /**
     * order number
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "invoice.orderId.type.integer")
     * @Assert\Range(max=10, maxMessage = "invoice.orderId.range.max")
     */
    public $orderId;

    /**
     * external ID which is be known in all systems
     * @var string
     * 
     * @SapAssert\Length(max=20, maxMessage = "invoice.externalId.length.max")
     */
    public $externalId;

    /**
     * type invoice
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *      Invoice::TYPE_MONEY_TRANSFER,
     *      Invoice::TYPE_ORGANIZER_INVOICE,
     *      Invoice::TYPE_CONCLUSION,
     *      Invoice::TYPE_PRESALE_INVOICE,
     *      Invoice::TYPE_OPTION,
     *      Invoice::TYPE_RETURN,
     *      Invoice::TYPE_INVOICE
     *   },
     *   message = "invoice.type.choice"
     * )
     */
    public $type;

    /**
     * invoice date
     * @var string
     *
     * @SapAssert\DateTime(format="YmdHi", message = "invoice.date.dateTime")
     */
    public $date;

    /**
     * company object
     * @var \SAP\EventTicketing\DataExchangeObject\Customer\Company
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\Company",
     *   message = "invoice.company.type.company"
     * )
     * @Assert\Valid
     */
    public $company;

    /**
     * user object
     * @var \SAP\EventTicketing\DataExchangeObject\User
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\User", message = "invoice.user.type.user"
     * )
     * @Assert\Valid
     */
    public $user;

    /**
     * customer object
     * @var \SAP\EventTicketing\DataExchangeObject\Customer
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Customer", message = "invoice.customer.type.customer")
     * @Assert\Valid
     */
    public $customer;

    /**
     * shipping address object
     * @var \SAP\EventTicketing\DataExchangeObject\Customer\Address
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\Address",
     *   message = "invoice.shippingAddress.type.address"
     * )
     * @Assert\Valid
     */
    public $shippingAddress;

    /**
     * invoice address object
     * @var \SAP\EventTicketing\DataExchangeObject\Customer\Address
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Customer\Address",
     *   message = "invoice.invoiceAddress.type.address"
     * )
     * @Assert\Valid
     */
    public $invoiceAddress;

    /**
     * array of product objects
     * @var ProductCollection=\SAP\EventTicketing\DataExchangeObject\Product[]
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\ProductCollection",
     *   message = "invoice.products.type.productCollection"
     * )
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Product",
     *     message = "invoice.products.all.type.product"
     *   )
     * })
     * @Assert\Valid
     */
    public $products;

    /**
     * array of cost objects
     * @var CostCollection=\SAP\EventTicketing\DataExchangeObject\Cost[]
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\CostCollection", message = "invoice.expenses.type.costCollection")
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Cost",
     *     message = "invoice.expenses.all.type.cost"
     *   )
     * })
     * @Assert\Valid
     */
    public $expenses;

    /**
     * array of price objects
     * @var PriceCollection=\SAP\EventTicketing\DataExchangeObject\Price[]
     * 
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\PriceCollection", message = "invoice.prices.type.priceCollection")
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Price",
     *     message = "invoice.prices.all.type.price"
     *   )
     * })
     * @Assert\Valid
     */
    public $prices;

    /**
     * payment type
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     InvoicePayment::TYPE_CASH,
     *     InvoicePayment::TYPE_OPTION,
     *     InvoicePayment::TYPE_CREDIT_CARD,
     *     InvoicePayment::TYPE_MONEY_CARD,
     *     InvoicePayment::TYPE_DEBIT_NOTE,
     *     InvoicePayment::TYPE_TRANSFER,
     *     InvoicePayment::TYPE_CHECK,
     *     InvoicePayment::TYPE_COUPON,
     *     InvoicePayment::TYPE_MOBILE_PHONE,
     *     InvoicePayment::TYPE_INVOICE,
     *     InvoicePayment::TYPE_CASH_ON_DELIVERY,
     *     InvoicePayment::TYPE_LOAN,
     *     InvoicePayment::TYPE_BANK_WITHDRAW,
     *     InvoicePayment::TYPE_BANK_WITHDRAW_WITH_PROBLEM,
     *     InvoicePayment::TYPE_EVENING_CASH_REGISTER,
     *     InvoicePayment::TYPE_ATM,
     *     InvoicePayment::TYPE_PAYMENT_METHOD_SPLITTING,
     *     InvoicePayment::TYPE_ADDITIONAL_PAYMENT_METHODS,
     *     InvoicePayment::TYPE_POINTS_CARD,
     *     InvoicePayment::TYPE_SEPA_DEBIT_NOTE,
     *   },
     *   message = "invoice.paymentType.choice"
     * )
     */
    public $paymentType;

    /**
     * payment date
     * @var string
     *
     * @SapAssert\DateTime(format="YmdHi", message = "invoice.paymentDate.dateTime")
     */
    public $paymentDate;

    /**
     * array of extra objects
     * @var ExtraCollection=\SAP\EventTicketing\DataExchangeObject\Extra[]
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\ExtraCollection", message = "invoice.extras.type.extraCollection")
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Extra",
     *     message = "invoice.extras.all.type.extra"
     *   )
     * })
     * @Assert\Valid
     */
    public $extras;

    /**
     * array of payment objects
     * @var InvoicePaymentCollection=\SAP\EventTicketing\DataExchangeObject\InvoicePayment[]
     * 
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\InvoicePaymentCollection", message = "invoice.payments.type.invoicePaymentCollection")
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\InvoicePayment",
     *     message = "invoice.payments.all.type.invoicePayment"
     *   )
     * })
     * @Assert\Valid
     */
    public $payments;

    /**
     * shipment object
     * @var \SAP\EventTicketing\DataExchangeObject\Shipment
     *
     * @Assert\Type(
     *   type = "SAP\EventTicketing\DataExchangeObject\Shipment",
     *   message = "invoice.shipment.type.shipment"
     * )
     * @Assert\Valid
     */
    public $shipment;

    /**
     * array of Notice objects
     * @var NoticeCollection=\SAP\EventTicketing\DataExchangeObject\Notice[]
     * 
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\NoticeCollection", message = "invoice.notices.type.noticeCollection")
     * @Assert\All({
     *   @Assert\Type(
     *     type = "SAP\EventTicketing\DataExchangeObject\Notice",
     *     message = "invoice.notices.all.type.notice"
     *   )
     * })
     * @Assert\Valid
     */
    public $notices;

    public function __construct ()
    {
        $this->products = new ProductCollection();
        $this->expenses = new CostCollection();
        $this->prices = new PriceCollection();
        $this->extras = new ExtraCollection();
        $this->payments = new InvoicePaymentCollection();
        $this->notices = new NoticeCollection();
    }
}
