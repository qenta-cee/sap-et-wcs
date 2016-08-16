<?php
namespace SAP\EventTicketing\DataExchangeObject\Customer;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * SEPA mandate for customer
 * @webserializable
 */
class SepaMandate
{
    const STATUS_CREATED = 'CREATED';
    const STATUS_VALID = 'VALID';
    const STATUS_INVALID = 'INVALID';
    const STATUS_NOT_VISIBLE = 'NOTVISIBLE';

    const MANDATE_TYPE_SINGLE_MANDATE_FOR_SINGLE_USE = 'SINGLE_MANDATE_FOR_SINGLE_USE'; // Einzelmandat einmalige Nutzung zum Kauf von Tickets oder Artikel
    const MANDATE_TYPE_SINGLE_MANDATE_FOR_MULTIUSE = 'SINGLE_MANDATE_FOR_MULTIUSE'; // Einzelmandat mehrmalige Nutzung zum Kauf von Tickets oder Artikel
    const MANDATE_TYPE_SINGLE_MANDATE_MITGLIEDSVERWALTUNG = 'SINGLE_MANDATE_MITGLIEDSVERWALTUNG'; //Einzelmandat mehrmalige Nutzung zum Einzug von Mitgliedsbeitraegen
    const MANDATE_TYPE_MULTIMANDATE_FOR_MULTIUSE = 'MULTIMANDATE_FOR_MULTIUSE'; //Sammelmandat mehrmalige Nutzung saemtlicher Forderungsarten
    const MANDATE_TYPE_SINGLE_MANDATE_INSTALLMENT_PAYMENT = 'SINGLE_MANDATE_INSTALLMENT_PAYMENT'; //Einzelmandat mehrmalige Nutzung von Ratenzahlung, mit definiertem Enddatum

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "sepaMandate.id.type.integer")
     */
    public $id;

    /**
     * external ID which is be known in all systems
     * @var string
     *
     * @Assert\NotBlank(message = "sepaMandate.externalId.notBlank")
     * @SapAssert\Length(max = 40, maxMessage = "sepaMandate.externalId.length.max")
     */
    public $externalId;

    /**
     * tid of customer
     * @var string
     *
     * @SapAssert\Length(max = 20, maxMessage = "sepaMandate.customerId.length.max")
     */
    public $customerId;

    /**
     * mandate reference number
     * @var string
     *
     * @Assert\NotBlank(message = "sepaMandate.mandateReference.notBlank")
     * @SapAssert\Length(max = 35, maxMessage = "sepaMandate.mandateReference.length.max")
     */
    public $mandateReference;

    /**
     * creditor identification number
     * @var string
     *
     * @Assert\NotBlank(message = "sepaMandate.creditorIdentifier.notBlank")
     * @SapAssert\Length(max = 35, maxMessage = "sepaMandate.creditorIdentifier.length.max")
     */
    public $creditorIdentifier;

    /**
     * IBAN of mandate / bank account
     * @var string
     *
     * @Assert\NotBlank(message = "sepaMandate.iban.notBlank")
     * @Assert\Iban(message = "sepaMandate.iban.iban")
     */
    public $iban;

    /**
     * BIC/Swift of mandate / bank account
     * @var string
     *
     * @Assert\NotBlank(message = "sepaMandate.swift.notBlank")
     * @SapAssert\Length(max = 11, maxMessage = "sepaMandate.swift.length.max")
     */
    public $swift;

    /**
     * external ID of the assigned bank account
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "sepaMandate.externalBankAccountId.type.integer")
     */
    public $externalBankAccountId;

    /**
     * date of signature
     * @var string
     *
     * @SapAssert\Date(message = "sepaMandate.dateOfSignature.date")
     */
    public $dateOfSignature;

    /**
     * flag shows if signed mandate exists in written form
     * @var boolean
     * @access public
     */
    public $writtenMandate;

    /**
     * mandate status
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     SepaMandate::STATUS_CREATED,
     *     SepaMandate::STATUS_VALID,
     *     SepaMandate::STATUS_INVALID,
     *     SepaMandate::STATUS_NOT_VISIBLE
     *   },
     *   message = "sepaMandate.status.choice"
     * )
     */
    public $status;

    /**
     * mandate creation date
     * @var string
     *
     * @SapAssert\Date(message = "sepaMandate.creationDate.date")
     */
    public $creationDate;

    /**
     * date of last use of mandate
     * @var string
     *
     * @SapAssert\Date(message = "sepaMandate.lastExecution.date")
     */
    public $lastExecution;

    /**
     * name of bank
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "sepaMandate.nameOfBank.length.max")
     */
    public $nameOfBank;

    /**
     * type of mandate
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     SepaMandate::MANDATE_TYPE_SINGLE_MANDATE_FOR_SINGLE_USE,
     *     SepaMandate::MANDATE_TYPE_SINGLE_MANDATE_FOR_MULTIUSE,
     *     SepaMandate::MANDATE_TYPE_SINGLE_MANDATE_MITGLIEDSVERWALTUNG,
     *     SepaMandate::MANDATE_TYPE_MULTIMANDATE_FOR_MULTIUSE,
     *     SepaMandate::MANDATE_TYPE_SINGLE_MANDATE_INSTALLMENT_PAYMENT
     *   },
     *   message = "sepaMandate.mandateType.choice"
     * )
     */
    public $mandateType;

    /**
     * @param string $externalId          Externe ID
     * @param string $creditorIdentifier  GläubigerID
     * @param string $mandateReference    Mandatsreferenznr
     * @param string $iban                IBAN
     * @param string $swift               Swiftcode / BIC
     */
    function __construct($externalId, $creditorIdentifier, $mandateReference, $iban, $swift)
    {
        $this->externalId = $externalId;
        $this->creditorIdentifier = $creditorIdentifier;
        $this->mandateReference = $mandateReference;
        $this->iban = $iban;
        $this->swift = $swift;
    }
}
