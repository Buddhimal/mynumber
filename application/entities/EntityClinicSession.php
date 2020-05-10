<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EntityClinicSession
{
	public $id = null;
	public $day = null;
	public $starting_time = null;
	public $end_time = null;
	public $consultant = null;
	public $session_name = null;
	public $session_description = null;

	function __construct($data = null)
	{
		if (!is_null($data)) {
			$this->id = $data->id;
			$this->day = $data->day;
			$this->starting_time = $data->starting_time;
			$this->end_time = $data->end_time;
			$this->consultant = $data->consultant;
			$this->session_name = $data->session_name;
			$this->session_description = $data->session_description;
		}
	}
}
