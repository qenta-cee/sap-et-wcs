<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

class BankAccount
{
    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "bankAccount.id.type.integer")
     */
    public $id;

    /**
     * external ID which is be known in all systems
     * @var string
     *
     * @SapAssert\Length(max = 40, maxMessage = "bankAccount.externalId.length.max")
     */
    public $externalId;

    /**
     * Name of bank
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "bankAccount.nameOfBank.length.max")
     */
    public $nameOfBank;

    /**
     * Bank code
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "bankAccount.bankCode.length.max")
     */
    public $bankCode;

    /**
     * account number
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "bankAccount.accountNumber.length.max")
     */
    public $accountNumber;

    /**
     * IBAN
     * @var string
     *
     * @Assert\Iban(message = "bankAccount.iban.iban")
     */
    public $iban;

    /**
     * BIC
     * @var string
     *
     * @SapAssert\Length(max = 11, maxMessage = "bankAccount.bic.length.max")
     */
    public $bic;

    /**
     * account owner
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "bankAccount.owner.length.max")
     */
    public $owner;

    /**
     * deactivated
     * @var boolean
     *
     * @Assert\Type(type = "bool", message = "bankAccount.deactivated.type.bool")
     */
    public $deactivated = false;

    /**
     * @param string $externalId Externe ID
     * @param string $iban IBAN
     * @param string $bic Swiftcode / BIC
     */
    function __construct($externalId, $iban, $bic)
    {
        $this->externalId = $externalId;
        $this->iban = $iban;
        $this->bic = $bic;
    }
}
