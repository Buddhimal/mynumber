<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EntityClinicPendingPaymentDetails
{

    public $sessions;
    public $grand_total;
    public $comision;
    public $netpay;

    public $from;
    public $to;


    function __construct()
    {
        //default constructor
        $this->sessions = array();
        $this->grand_total = 0;
    }


    public function add_session($session)
    {
        $this->sessions[] = $session;
        $this->grand_total += $session->total;
        $this->comision = ( ( $this->grand_total / 100 ) * Payments::getPercentage() );
        $this->netpay = $this->grand_total - $this->comision;
    }
}