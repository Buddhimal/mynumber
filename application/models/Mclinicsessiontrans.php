<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mclinicsessiontrans extends CI_Model{

	public $validation_errors = array();
	private $post = array();
	protected $table = "clinic_session_trans";

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

	public function start_session($session_id)
	{
		$result = false;

		$id = trim($this->mmodel->getGUID(), '{}');
		$this->post['id'] = $id;
		$this->post['clinic_date'] = date("Y-m-d");
		$this->post['clinic_session_id'] = $session_id;
		$this->post['action'] = SessionStatus::START;

		$additional_data['action']="start";
		$additional_data['action_datetime']=date("Y-m-d h:i:s");

		$this->post['additional_data'] = json_encode($additional_data);
		$this->post['action_datetime'] = date("Y-m-d h:i:s");
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $id;
		$this->post['created_by'] = $id;

		$this->mmodel->insert($this->table, $this->post);

		if ($this->db->affected_rows()>0) {
			$result = true;
		}
		return $result;
	}

	public function finish_session($session_id)
	{
		$result = false;

		$id = trim($this->mmodel->getGUID(), '{}');
		$this->post['id'] = $id;
		$this->post['clinic_date'] = date("Y-m-d");
		$this->post['clinic_session_id'] = $session_id;
		$this->post['action'] = SessionStatus::FINISHED;
		$this->post['additional_data'] = NULL;
		$this->post['action_datetime'] = date("Y-m-d h:i:s");
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $id;
		$this->post['created_by'] = $id;

		$this->mmodel->insert($this->table, $this->post);

		if ($this->db->affected_rows()>0) {
			$result = true;
		}
		return $result;
	}


	public function create()
	{
		$result = false;


		return $result;
	}

}
