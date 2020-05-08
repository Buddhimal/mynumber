<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mclinicholidays extends CI_Model
{
	public $validation_errors = array();
	private $post = array();
	protected $table = "clinic_holidays";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


	public function set_data($post_array)
	{
		if (isset($post_array['date']))
			$this->post['holiday'] = $post_array['date'];
	}

	public function is_valid()
	{
		unset($this->validation_errors);
		$this->validation_errors = array();

		$result = true;

		if (!(isset($this->post['holiday']) && $this->post['holiday'] != NULL && $this->post['holiday'] != '' && $this->mvalidation->valid_date($this->post['holiday']) == TRUE)) {
			array_push($this->validation_errors, 'Invalid Date format.');
			$result = false;
		}

		return $result;
	}

	/*
	*
	*/
	public function create($clinic_id)
	{
		$result = null;

		$session_id = trim($this->mmodel->getGUID(), '{}');

		$this->post['id'] = $session_id;
		$this->post['clinic_id'] = $clinic_id;
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $session_id;
		$this->post['created_by'] = $session_id;

		$this->mmodel->insert($this->table, $this->post);

		if ($this->db->affected_rows() > 0) {
			$result = $this->get($session_id);
		}

		return $result;
	}


	public function get($id)
	{

		$query_result = $this->get_record($id);

		return new EntityClinicSession($query_result);
	}

	private function get_record($id)
	{

		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}

}
