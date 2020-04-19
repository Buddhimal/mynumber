<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdoctor extends CI_Model
{
	public $validation_errors = array();
	private $post = array();
	protected $table = "doctor";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


	public function set_data($post_array){

		
		$this->post['salutation'] = $post_array['salutation'];
		$this->post['first_name'] = $post_array['firstname'];
		$this->post['last_name'] = $post_array['lastname'];
		$this->post['known_name'] = $post_array['wellknownas'];
		$this->post['contact_telephone'] = $post_array['telephone'];
		$this->post['email'] = $post_array['email'];
		$this->post['specialities'] = $post_array['specialities'];
		$this->post['slmc_reg_number'] = $post_array['slmc_reg_number'];
		$this->post['consulting_hospitals'] = $post_array['consulting_hospitals'];

	}

	public function is_valid()
	{
		$result = true;

		if (!(isset($this->post['salutation']) &&  $this->post['salutation'] != NULL && $this->post['salutation'] != '')){
			array_push($this->validation_errors, 'Invalid Salutation.');
			$result = false;
		}

		if (!(isset($this->post['firstname']) &&  $this->post['firstname'] != NULL && $this->post['firstname'] != '')) {
			array_push($this->validation_errors, 'Invalid First Name.');
			$result = false;
		}

		if (!(isset($this->post['lastname']) &&  $this->post['lastname'] != NULL && $this->post['lastname'] != '')) {
			array_push($this->validation_errors, 'Invalid Last Name.');
			$result = false;
		}

		if (!(isset($this->post['slmc_reg_number']) &&  $this->post['slmc_reg_number'] != NULL && $this->post['slmc_reg_number'] != '')) {
			array_push($this->validation_errors, 'Invalid SLMC Reg Number.');
			$result = false;
		}

		if (!(isset($this->post['email']) &&  $this->mvalidation->email($this->post['email']))) {
			array_push($this->validation_errors, 'Invalid Email.');
			$result = false;
		}

		if (!(isset($this->post['device_mobile']) &&  $this->mvalidation->telephone($this->post['device_mobile']))) {
			array_push($this->validation_errors, 'Invalid Device Mobile.');
			$result = false;
		}

		return $result;
	}


	/*
	*
	*/
	public function create(){

		$result = null;

		$this->post['id'] = trim(com_create_guid(), '{}');
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $doctor_id;
		$this->post['created_by'] = $doctor_id;

		if( $this->insert($this->table, $this->post)){
			$result = $this->get_doctor();
		}

		return $result;
	}

	/*
	*
	*/
	public function get_doctor($id){
		$CI = &get_instance();
		$query_result = $this->select("*")->from($this->table)->where( sprintf("id='%s'", $id) )->getRow(0);
		$CI->load->entity('EntityConsultant', $query_result, 'doctor_response');
		return $CI->doctor_response;
	}

}
