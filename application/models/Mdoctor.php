<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");

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


	public function set_data($post_array)
	{
		if (isset($post_array['salutation']))
			$this->post['salutation'] = $post_array['salutation'];
		if (isset($post_array['firstname']))
			$this->post['first_name'] = $post_array['firstname'];
		if (isset($post_array['lastname']))
			$this->post['last_name'] = $post_array['lastname'];
		if (isset($post_array['nic']))
			$this->post['nic'] = $post_array['nic'];
		if (isset($post_array['known_name']))
			$this->post['known_name'] = $post_array['wellknownas'];
		if (isset($post_array['location']))
			$this->post['location'] = $post_array['location'];
		if (isset($post_array['contact_telephone']))
			$this->post['contact_telephone'] = $post_array['contact_telephone'];
		if (isset($post_array['contact_mobile']))
			$this->post['contact_mobile'] = $post_array['contact_mobile'];
		if (isset($post_array['device_mobile']))
			$this->post['device_mobile'] = $post_array['device_mobile'];
		if (isset($post_array['email']))
			$this->post['email'] = $post_array['email'];
		if (isset($post_array['specialities']))
			$this->post['specialities'] = $post_array['specialities'];
		if (isset($post_array['doctor_code']))
			$this->post['doctor_code'] = $post_array['doctor_code'];
		if (isset($post_array['slmc_reg_number']))
			$this->post['slmc_reg_number'] = $post_array['slmc_reg_number'];
		if (isset($post_array['consulting_hospitals']))
			$this->post['consulting_hospitals'] = $post_array['consulting_hospitals'];

	}

	public function is_valid()
	{
		$result = true;

		if (!(isset($this->post['salutation']) && $this->post['salutation'] != NULL && $this->post['salutation'] != '')) {
			array_push($this->validation_errors, 'Invalid Salutation.');
			$result = false;
		}

		if (!(isset($this->post['first_name']) && $this->post['first_name'] != NULL && $this->post['first_name'] != '')) {
			array_push($this->validation_errors, 'Invalid First Name.');
			$result = false;
		}

		if (!(isset($this->post['last_name']) && $this->post['last_name'] != NULL && $this->post['last_name'] != '')) {
			array_push($this->validation_errors, 'Invalid Last Name.');
			$result = false;
		}

		if (!(isset($this->post['slmc_reg_number']) && $this->post['slmc_reg_number'] != NULL && $this->post['slmc_reg_number'] != '')) {
			array_push($this->validation_errors, 'Invalid SLMC Reg Number.');
			$result = false;
		}

		if (!(isset($this->post['email']) && $this->mvalidation->email($this->post['email']))) {
			array_push($this->validation_errors, 'Invalid Email.');
			$result = false;
		}

		if (!(isset($this->post['device_mobile']) && $this->mvalidation->telephone($this->post['device_mobile']))) {
			array_push($this->validation_errors, 'Invalid Device Mobile.');
			$result = false;
		}

		return $result;
	}


	/*
	*
	*/
	public function create()
	{

		$result = null;

		$doctor_id = trim(com_create_guid(), '{}');
		$this->post['id'] = $doctor_id;
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $doctor_id;
		$this->post['created_by'] = $doctor_id;

		if ($this->mmodel->insert($this->table, $this->post)) {
			$result = $this->get_doctor($doctor_id);
		}
		$result = $this->get_doctor($doctor_id);

		return $result;
	}

	/*
	*
	*/
	public function get_doctor($id)
	{
		$CI = &get_instance();

		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $id);

		$query_result = $this->db->get()->row();

//		var_dump($query_result);
//		die();

//		$query_result = $this->db->select("*")->from($this->table)->where(sprintf("id='%s'", $id))->ow(0);

		$CI->load->entity('EntityConsultant', $query_result, 'doctor_response');
		return $CI->doctor_response;
	}

}
