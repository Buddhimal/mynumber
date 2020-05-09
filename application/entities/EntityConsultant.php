<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class EntityConsultant
{
	public $id=null;
	public $salutation = null;
	public $firstname = null;
	public $lastname = null;
	public $nic = null;
	public $contact_telephone = null;
	public $contact_mobile = null;
	public $device_mobile = null;
	public $email = null;
	public $wellknownas = null;
	public $location = null;
	public $specialities = null;
	public $doctor_code = null;
	public $slmc_reg_number = null;
	public $consulting_hospitals = null;
//	public $created = null;
//	public $updated = null;
//	public $is_active = null;
//	public $is_deleted = null;
//	public $updated_by = null;
//	public $created_by = null;

	function __construct($data=null){
		if(!is_null($data)){
			$this->id = $data->id;
			$this->salutation = $data->salutation;
			$this->firstname = $data->first_name;
			$this->lastname = $data->last_name;
			$this->nic = $data->nic;
			$this->wellknownas = $data->known_name;
			$this->location = $data->location;
			$this->contact_telephone = $data->contact_telephone;
			$this->contact_mobile = $data->contact_mobile;
			$this->device_mobile = $data->device_mobile;
			$this->email = $data->email;
			$this->specialities = $data->specialities;
			$this->slmc_reg_number = $data->slmc_reg_number;
			$this->doctor_code = $data->doctor_code;
			$this->consulting_hospitals = $data->consulting_hospitals;
//			$this->created = $data->created;
//			$this->updated = $data->updated;
//			$this->is_active = $data->is_active;
//			$this->is_deleted = $data->is_deleted;
//			$this->updated_by = $data->updated_by;
//			$this->created_by = $data->created_by;
		}
	}
}
