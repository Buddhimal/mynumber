<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mclinicappointmenttrans extends CI_Model
{

	public $validation_errors = array();
	private $post = array();
	protected $table = "clinic_appointment_trans";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


	public function set_data($post_array)
	{
		// $this->post = $post_array
	}

	public function is_valid()
	{
		$result = true;

		/*
		 Validation logics goes here
		*/

		return $result;
	}


	/*
	*
	*/
	public function create($appointment_id, $status)
	{
		$result = false;

		$id = trim($this->mmodel->getGUID(), '{}');

		$this->post['id'] = $id;
		$this->post['clinic_appointment_id'] = $appointment_id;
		$this->post['action'] = $status;
		$this->post['action_datetime'] = date("Y-m-d");
		$this->post['additional_data'] = null;
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $id;
		$this->post['created_by'] = $id;

		$this->db->insert($this->table, $this->post);

		if ($this->db->affected_rows() > 0) {
			$result = true;
		}

		return $result;
	}

}
