<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class EntityConsultant
{
	public $id=null;
	public $salutation = null;
	public $firstname = null;
	public $lastname = null;
	public $wellknownas = null;
	public $telephone = null;
	public $mobile = null;
	public $email = null;
	public $specialities = null;
	public $slmc_reg_number = null;
	public $consulting_hospitals = null;
	public $created = null;
	public $updated = null;
	public $is_active = null;
	public $is_deleted = null;

	function __construct($data=null){
		if(!is_null($data)){
			$this->id = $data['id'];
			$this->salutation = $data['salutation'];
			$this->firstname = $data['first_name'];
			$this->lastname = $data['last_name'];
			$this->wellknownas = $data['known_name'];
			$this->telephone = $data['contact_telephone'];
			$this->mobile = $data['contact_mobile'];
			$this->email = $data['email'];
			$this->specialities = $data['specialities'];
			$this->slmc_reg_number = $data['slmc_reg_number'];
			$this->consulting_hospitals = $data['consulting_hospitals'];
			$this->created = $data['created'];
			$this->updated = $data['updated'];
			$this->is_active = $data['is_active'];
			$this->is_deleted = $data['is_deleted'];
		}
	}
}
