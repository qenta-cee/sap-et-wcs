<?php
namespace SAP\EventTicketing\DataExchangeObject;

use Symfony\Component\Validator\Constraints as Assert;
use SAP\EventTicketing\Validator\Constraints as SapAssert;

/**
 * Performance
 * @webserializable
 */
class Performance
{
    const STATE_NORMAL = '';
    const STATE_CLEARED = 'CLEARED'; // Sperre / abgerechnet (nicht buchbar)
    const STATE_EDITING = 'EDITING'; // Vorstellung in Bearbeitung (nicht buchbar)
    const STATE_CANCELED = 'CANCELED'; // Ausfall (nicht buchbar)
    const STATE_PRE_SELLING_EXPIRED = 'PRE_SELLING_EXPIRED'; // VVK abgelaufen (nicht buchbar)
    const STATE_PRE_SELLING_EXPIRED_ONLY_BOX_OFFICE = 'PRE_SELLING_EXPIRED_ONLY_BOX_OFFICE'; // VVK abgelaufen, Karten an AK (nicht buchbar)
    const STATE_PRE_SELLING_UNKNOWN = 'PRE_SELLING_ANNOUNCED'; // VVK-Beginn unbekannt (nicht buchbar)
    const STATE_PRE_SELLING_NOT_REACHED = 'PRE_SELLING_NOT_REACHED'; // VVK-Beginn noch nicht erreicht (nicht buchbar)
    const STATE_VENUE_POSTPONED = 'VENUE_POSTPONED'; // Veranstaltungsort verlegt (nicht buchbar)
    const STATE_DATE_POSTPONED = 'DATE_POSTPONED'; // Termin verlegt (buchbar)

    /**
     * primary identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "performance.id.type.integer")
     */
    public $id;

    /**
     * key
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "performance.key.length.max")
     */
    public $key;

    /**
     * name
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "performance.name.length.max")
     */
    public $name;

    /**
     * date
     * @var string
     *
     * @SapAssert\Date(message = "performance.dateFrom.date")
     */
    public $dateFrom;

    /**
     * time
     * @var string
     *
     * @SapAssert\Time(message = "performance.timeFrom.time")
     */
    public $timeFrom;

    /**
     * performance date to
     * @var string
     *
     * @SapAssert\Date(message = "performance.dateTo.date")
     */
    public $dateTo;

    /**
     * performance time to
     * @var string
     *
     * @SapAssert\Time(message = "performance.timeTo.time")
     */
    public $timeTo;

    /**
     * state
     * @var string
     *
     * @Assert\Choice(
     *   choices = {
     *     Performance::STATE_NORMAL,
     *     Performance::STATE_CLEARED,
     *     Performance::STATE_EDITING,
     *     Performance::STATE_CANCELED,
     *     Performance::STATE_PRE_SELLING_EXPIRED,
     *     Performance::STATE_PRE_SELLING_EXPIRED_ONLY_BOX_OFFICE,
     *     Performance::STATE_PRE_SELLING_UNKNOWN,
     *     Performance::STATE_PRE_SELLING_NOT_REACHED,
     *     Performance::STATE_VENUE_POSTPONED,
     *     Performance::STATE_DATE_POSTPONED,
     *   },
     *   message = "performance.state.choice"
     * )
     */
    public $state;

    /**
     * category
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "performance.category.length.max")
     */
    public $category;

    /**
     * venue object
     * @var \SAP\EventTicketing\DataExchangeObject\Venue
     *
     * @Assert\Type(type = "SAP\EventTicketing\DataExchangeObject\Venue", message = "performance.venue.type.venue")
     * @Assert\Valid
     */
    public $venue;

    /**
     * event name
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "performance.event.length.max")
     */
    public $event;

    /**
     * event identifier
     * @var integer
     *
     * @Assert\Type(type = "integer", message = "performance.eventId.type.integer")
     */
    public $eventId;

    /**
     * additional information
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "performance.additionalInformation1.length.max")
     */
    public $additionalInformation1;

    /**
     * additional information
     * @var string
     *
     * @SapAssert\Length(max = 255, maxMessage = "performance.additionalInformation2.length.max")
     */
    public $additionalInformation2;
}
