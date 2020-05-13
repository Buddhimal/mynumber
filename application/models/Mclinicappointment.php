<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mclinicappointment extends CI_Model
{

	public $validation_errors = array();
	private $post = array();
	protected $table = "clinic_appointments";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


	public function set_data($post_array)
	{
		if (isset($post_array['serial_number']))
			$this->post['serial_number'] = $post_array['serial_number'];
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
	public function create()
	{

		$result = null;

		$appointment_id = trim($this->mmodel->getGUID(), '{}');

		$this->post['id'] = $appointment_id;
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $appointment_id;
		$this->post['created_by'] = $appointment_id;

		$this->mmodel->insert($this->table, $this->post);

		if ($this->db->affected_rows() > 0) {
			//$result = $this->get($appointment_id);
		}

		return $result;
	}
}
