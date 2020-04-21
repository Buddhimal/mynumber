<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EntityPublic
{
	public $id = null;
	public $salutation = null;
	public $firstname = null;
	public $lastname = null;
	public $nic = null;
	public $telephone = null;
	public $email = null;
	public $location = null;
	public $patient_code = null;
	public $created = null;
	public $updated = null;
	public $is_active = null;
	public $is_deleted = null;
	public $updated_by = null;
	public $created_by = null;

	function __construct($data = null)
	{
		if (!is_null($data)) {
			$this->id = $data->id;
			$this->salutation = $data->salutation;
			$this->firstname = $data->first_name;
			$this->lastname = $data->last_name;
			$this->nic = $data->nic;
			$this->location = $data->location;
			$this->telephone = $data->telephone;
			$this->email = $data->email;
			$this->patient_code = $data->patient_code;
			$this->created = $data->created;
			$this->updated = $data->updated;
			$this->is_active = $data->is_active;
			$this->is_deleted = $data->is_deleted;
			$this->updated_by = $data->updated_by;
			$this->created_by = $data->created_by;
		}
	}
}
