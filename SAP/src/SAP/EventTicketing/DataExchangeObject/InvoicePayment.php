<?php
namespace SAP\EventTicketing\DataExchangeObject;

use SAP\EventTicketing\DataExchangeObject\Customer\SepaMandate;
use SAP\EventTicketing\DataExchangeObject\Customer\BankAccount;
use SAP\EventTicketing\DataExchangeObject\PaymentTransaction;
use SAP\EventTicketing\DataExchangeObject\Price;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * handles payment information
 */
class InvoicePayment
{
    const TYPE_CASH = 'CASH';
    const TYPE_OPTION = 'OPTION';
    const TYPE_CREDIT_CARD = 'CREDIT_CARD';
    const TYPE_MONEY_CARD = 'MONEY_CARD';
    const TYPE_DEBIT_NOTE = 'DEBIT_NOTE';
    const TYPE_TRANSFER = 'TRANSFER';
    const TYPE_CHECK = 'CHECK';
    const TYPE_COUPON = 'COUPON';
    const TYPE_MOBILE_PHONE = 'MOBILE_PHONE';
    const TYPE_INVOICE = 'INVOICE';
    const TYPE_CASH_ON_DELIVERY = 'CASH_ON_DELIVERY';
    const TYPE_LOAN = 'LOAN';
    const TYPE_BANK_WITHDRAW = 'BANK_WITHDRAW_DTA';
    const TYPE_BANK_WITHDRAW_WITH_PROBLEM = 'BANK_WITHDRAW_WITH_PROBLEM_DTA';
    const TYPE_EVENING_CASH_REGISTER = 'EVENING_CASH_REGISTER';
    const TYPE_ATM = 'CASH_DISPENSER';
    const TYPE_PAYMENT_METHOD_SPLITTING = 'PAYMENT_METHOD_SPLITTING';
    const TYPE_ADDITIONAL_PAYMENT_METHODS = 'ADDITIONAL_PAYMENT_METHOD';
    const TYPE_POINTS_CARD = 'POINTS_CARD';
    const TYPE_SEPA_DEBIT_NOTE = 'SEPA_DEBIT_NOTE';

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "int", message = "invoicePayment.id.type.integer")
     */
    public $id;

    /**
     * type
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
     *   message = "invoiceReference.type.choice"
     * )
     */
    public $type;

    /**
     * transaction identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "invoicePayment.transactionId.type.integer")
     */
    public $transactionId;

    /**
     * coupon number
     * @var string
     *
     * @SapAssert\Length(max = 1024, maxMessage = "invoicePayment.couponNumber.length.max")
     */
    public $couponNumber;

    /**
     * price object
     * @var \SAP\EventTicketing\DataExchangeObject\Price
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Price", message = "invoicePayment.price.type.price")
     * @Assert\Valid
     */
    public $price;

    /**
     * transaction object
     * @var \SAP\EventTicketing\DataExchangeObject\PaymentTransaction
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\PaymentTransaction", message = "invoicePayment.transaction.type.paymentTransaction")
     * @Assert\Valid
     * */
    public $transaction;

    /**
     * SEPA mandate object
     * @var \SAP\EventTicketing\DataExchangeObject\Customer\SepaMandate
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Customer\SepaMandate", message = "invoicePayment.sepaMandate.type.sepaMandate")
     * @Assert\Valid
     */
    public $sepaMandate;

    /**
     * bank account object
     * @var \SAP\EventTicketing\DataExchangeObject\Customer\BankAccount
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Customer\BankAccount", message = "invoicePayment.bankAccount.type.bankAccount")
     * @Assert\Valid
     */
    public $bankAccount;
}
