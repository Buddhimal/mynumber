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
//	public $created = null;
//	public $updated = null;
//	public $is_active = null;
//	public $is_deleted = null;
//	public $updated_by = null;
//	public $created_by = null;

	function __construct($data=null){
		if(!is_null($data)){
			$this->id = $data->id;
			$this->name = $data->clinic_name;
			$this->telephone = $data->telephone;
			$this->email = $data->email;
			$this->web = $data->web;
			$this->location = $data->location_id;
//			$this->created = $data->created;
//			$this->updated = $data->updated;
//			$this->is_active = $data->is_active;
//			$this->is_deleted = $data->is_deleted;
//			$this->updated_by = $data->updated_by;
//			$this->created_by = $data->created_by;
		}
	}
}
