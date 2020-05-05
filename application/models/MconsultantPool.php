<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MconsultantPool extends CI_Model{

	public $validation_errors = array();
	private $post = array();
	protected $table = "consultant_pool";

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
	public function create($doctor_id,$clinic_id)
	{
		$result = false;

		$id = trim(com_create_guid(), '{}');
		$this->post['id'] = $id;
		$this->post['consultant_id'] = $doctor_id;
		$this->post['clinic_id'] = $clinic_id;
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
		// Folowing line is commented out intentionally. do no uncomment - ASANKA
		// $result = $this->get($doctor_id);

		return $result;
	}

}
