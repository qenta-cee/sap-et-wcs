<?php
namespace SAP\EventTicketing\DataExchangeObject;

use SAP\EventTicketing\Validator\Constraints as SapAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cost
 * @webserializable
 */
class Cost
{
    const TYPE_BASIC = 'BASIC';
    const TYPE_SYSTEM = 'SYSTEM';
    const TYPE_PRESALE = 'PRESALE';
    const TYPE_OTHER = 'OTHER';

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "cost.id.type.integer")
     */
    public $id;

    /**
     * pre-tax price
     * @var \SAP\EventTicketing\DataExchangeObject\Price
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Price", message = "cost.brutto.type.price")
     * @Assert\Valid
     */
    public $preTax;

    /**
     * value added tax
     * @var double
     *
     * @Assert\Type(type = "double", message = "cost.vat.type.double")
     */
    public $vat;

    /**
     * cost type
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     Cost::TYPE_BASIC,
     *     Cost::TYPE_SYSTEM,
     *     Cost::TYPE_PRESALE,
     *     Cost::TYPE_OTHER
     *   },
     *   message = "cost.type.choice"
     * )
     */
    public $type;

    /**
     * account
     * @var \SAP\EventTicketing\DataExchangeObject\Account
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Account", message = "cost.account.type.account")
     * @Assert\Valid
     */
    public $account;

    /**
     * type of account
     * @var string
     *
     * @SapAssert\Length(max = 256, maxMessage = "cost.accountType.length.max")
     */
    public $accountType;

    /**
     * charge
     * @var \SAP\EventTicketing\DataExchangeObject\Charge
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Charge", message = "cost.charge.type.charge")
     * @Assert\Valid
     */
    public $charge;

    /**
     * charge type
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "cost.chargeType.length.max")
     */
    public $chargeType;

    /**
     * company
     * @var \SAP\EventTicketing\DataExchangeObject\Customer\Company
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Customer\Company", message = "cost.company.type.company")
     * @Assert\Valid
     */
    public $company;
}
