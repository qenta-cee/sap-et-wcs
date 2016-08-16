<?php
namespace SAP\EventTicketing\DataExchangeObject;

class PaymentTransaction
{
    /**
     * transaction ID (primary key)
     *
     * @var integer
     */
    public $tid;

    /**
     * ID of the company
     *
     * @var \SAP\EventTicketing\DataExchangeObject\Customer\Company
     */
    public $company;

    /**
     * ID of the current user for this transaction
     *
     * @var \SAP\EventTicketing\DataExchangeObject\User
     */
    public $user;

    /**
     * timestamp when the payment request was started
     *
     * @var string
     */
    public $startTime;

    /**
     * timestamp when the payment data was transferred to the gateway
     *
     * @var string
     */
    public $dataSendTime;

    /**
     * timestamp when the payment request was returned and completed from gateway
     *
     * @var string
     */
    public $completedTime;

    /**
     * key of the used payment gateway
     *
     * @var string
     */

    public $paymentGateway;

    /**
     * used payment method within this transaction
     *
     * @var string
     */
    public $paymentMethod;

    /**
     * value of transaction in MONEY-format
     *
     * @var \SAP\EventTicketing\DataExchangeObject\Price
     */
    public $value;

    /**
     * current status of the payment
     *   t = temporary (further data needed)
     *   b = basket (first step of payment is executed; payment booked into the basket)
     *   o = ordered (payment completed, basket was booked with this payment)
     *
     * @var string
     */
    public $paymentStatus;

    /**
     * gateway dependent key
     *
     * @var string
     */
    public $externalId;

    /**
     * count of executed payment runs
     *
     * @var integer
     */
    public $paymentRun;

    /**
     * print counter
     *
     * @var integer
     */
    public $printCount;

//  the following attributes are information from table PMTransactionData

    /**
     * @var string payment type (one of CC, DD, EPS, COU)
     */
    public $type;

    /**
     * @var string brand name of credit card (e.g. VISA, MC, AMEX, DC)
     */
    public $ccBrand;

    /**
     * @var string  ID of the payment transaction of the provider
     */
    public $providerTransactionId = '';

    /**
     * @var int order/transaction ID
     */
    public $orderId;

    /**
     * @var int state of the order
     */
    public $orderstate;

    /**
     * @var int account number of banking account/credit card
     */
    public $number;

    /**
     * @var int month of the validation date of a credit card
     */
    public $month;

    /**
     * @var int year of the validation date of a credit card
     */
    public $year;

    /**
     * @var int card validation code
     */
    public $cvCode;

    /**
     * @var string owner name of the banking account/ credit card
     */
    public $ownerName;

    /**
     * @var string bank identification number
     */
    public $bic;

    /**
     * @var string name of the banking institute
     */
    public $bankName;

    /**
     * @deprecated
     * @var string
     */
    public $track1;

    /**
     * @deprecated
     * @var string
     */
    public $track2;

    /**
     * @deprecated
     *
     * @var string
     */
    public $track3;

    /**
     * @deprecated
     *
     * @var string
     */
    public $magrun;

    /**
     * @var string serialized return data from payment gateway
     */
    public $gatewayData;
}
