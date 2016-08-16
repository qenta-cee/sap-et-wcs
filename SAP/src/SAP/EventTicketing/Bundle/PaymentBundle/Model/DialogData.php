<?php

namespace SAP\EventTicketing\Bundle\PaymentBundle\Model;

/**
 * model class to exchange data between dialogs within ET-system and payment gateway
 *
 * Class DialogData
 * @package SAP\EventTicketing\Bundle\PaymentBundle\Model
 */
class DialogData
{
    public $target;

    /**
     * @var string URL
     */
    public $url;

    /**
     * @var string  custom payment dialog
     */
    public $paymentdialog;

    /**
     * required form fields for the payment gateway in the dialog
     * @var FormField[]
     */
    public $FORM_FIELDS = array();
    /**
     * array with all parameters/variables transferred from the dialog
     * array ( key => value)
     */
    public $PAYMENTGATE_LAYOUTVARIABLES = array();

    /**
     * @var string  additional javascript for dialog
     */
    public $javascript;

    /**
     * @var string URL which will be used to forward to a new window.location
     */
    public $FORWARDURL;
    /**
     * @var string  URL to cancel the current transaction (will be set from system side)
     */
    public $cancelURL;

    /**
     * @var string  URL to complete successfully the current transaction (will be set from system side)
     */
    public $successURL;

    /**
     * @var string  URL to send a notification back for the current transaction (will be set from system side)
     */
    public $notifyURL;

    /**
     * this array can be used to transfer some old/deprecated attributes to the dialog
     * @var array (key => value)
     */
    public $DEPRICATED_ATTRIBUTES = array();
}
