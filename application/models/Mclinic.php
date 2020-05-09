<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mclinic extends CI_Model
{
	public $validation_errors = array();
	private $post = array();
	protected $table = "clinic";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


	public function set_data($post_array)
	{
		if (isset($post_array['name']))
			$this->post['clinic_name'] = $post_array['name'];
		if (isset($post_array['telephone']))
			$this->post['telephone'] = $post_array['telephone'];
		if (isset($post_array['email']))
			$this->post['email'] = $post_array['email'];
		if (isset($post_array['web']))
			$this->post['web'] = $post_array['web'];
	}

	public function is_valid()
	{
		$result = true;

		if (!(isset($this->post['clinic_name']) && $this->post['clinic_name'] != NULL && $this->post['clinic_name'] != '')) {
			array_push($this->validation_errors, 'Invalid Clinic Name.');
			$result = false;
		}

		if (!(isset($this->post['email']) && $this->mvalidation->email($this->post['email']))) {
			array_push($this->validation_errors, 'Invalid Email.');
			$result = false;
		}

		if (!(isset($this->post['telephone']) && $this->mvalidation->telephone($this->post['telephone']))) {
			array_push($this->validation_errors, 'Invalid Telephone.');
			$result = false;
		}

		return $result;
	}


	public function create($location_id=NULL)
	{
		$result = null;

		$clinic_id = trim($this->mmodel->getGUID(), '{}');
		$this->post['id'] = $clinic_id;
		$this->post['location_id'] = $location_id;
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 0;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $clinic_id;
		$this->post['created_by'] = $clinic_id;

		$this->mmodel->insert($this->table, $this->post);

		if ($this->db->affected_rows() > 0) {
			$result = $this->get($clinic_id);
		}

		return $result;
	}

	/*
		//	public function update($public_id)
		//	{
		//		$result = null;
		//		$update_data = array();
		//
		//		$current_public_data = $this->get_record($public_id);
		//
		//		if (isset($this->post['first_name']) && $this->post['first_name'] != $current_public_data->first_name)
		//			$update_data['first_name'] = $this->post['first_name'];
		//
		//		if (isset($this->post['last_name']) && $this->post['last_name'] != $current_public_data->last_name)
		//			$update_data['last_name'] = $this->post['last_name'];
		//
		//		if (isset($this->post['nic']) && $this->post['nic'] != $current_public_data->nic)
		//			$update_data['nic'] = $this->post['nic'];
		//
		//		if (isset($this->post['telephone']) && $this->post['telephone'] != $current_public_data->telephone)
		//			$update_data['telephone'] = $this->post['telephone'];
		//
		//		if (isset($this->post['email']) && $this->post['email'] != $current_public_data->email)
		//			$update_data['email'] = $this->post['email'];
		//
		//		if (isset($this->post['location']) && $this->post['location'] != $current_public_data->location)
		//			$update_data['location'] = $this->post['location'];
		//
		//		if (isset($this->post['patient_code']) && $this->post['patient_code'] != $current_public_data->patient_code)
		//			$update_data['patient_code'] = $this->post['patient_code'];
		//
		//		if (sizeof($update_data) > 0) {
		//			$update_data['updated'] = date("Y-m-d h:i:s");
		//			$update_data['updated_by'] = $public_id;
		//
		//			$this->db->where('id', $public_id);
		//			$this->db->update($this->table, $update_data);
		//
		//			if ($this->db->affected_rows() > 0) {
		//				// update successful
		//				$result = $this->get($public_id);
		//			}
		//		}
		//
		//		return $result;
		//	}
	*/

	private function get_record($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}

	public function get($id)
	{
		$query_result = $this->get_record($id);
		$CI = &get_instance();
		$CI->load->entity('EntityClinic', $query_result, 'clinic_response');

		return $CI->clinic_response;
	}


	function valid_clinic($id)
	{
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('id', $id);

		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
