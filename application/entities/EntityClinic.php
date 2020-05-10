<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class EntityClinic
{
	public $id=null;
	public $name = null;
	public $telephone = null;
	public $email = null;
	public $web = null;
	public $location = null;
	public $consultants=null;
	public $holidays = null;
	public $sessions = null;
	
	function __construct($data=null){
		if(!is_null($data)){
			$this->id = $data->id;
			$this->name = $data->clinic_name;
			$this->telephone = $data->telephone;
			$this->email = $data->email;
			$this->web = $data->web;
			$this->location = $data->location_id;
		}
	}
}
