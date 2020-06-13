<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class EntityClinicPendingPaymentDetails{

	public $sessions;
	public $grand_total;
	public $from;
	public $to;

	public EntityClinicPendingPaymentDetails(){
		//default constructor
		$this->sessions = array();
		$this->grand_total = 0;
	}

	public add_session($session){
		$this->sessions[] = $session;
		$this->grand_total += $session->total;
	}
}