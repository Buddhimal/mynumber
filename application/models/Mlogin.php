<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mlogin extends CI_Model
{

	public $validation_errors = array();
	public $post = array();
	protected $table = "muliti_user_login";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
		$this->load->library('Utilityhandler');

	}


	public function set_data($post_array)
	{
		if (isset($post_array['username']))
			$this->post['username'] = $post_array['username'];
		else
			$this->post['username'] = NULL;

		if (isset($post_array['password'])) {
			$this->post['password'] = $post_array['password'];
		}
		if (isset($post_array['mobile'])) {
			$this->post['mobile'] = $post_array['mobile'];
		}
	}

	public function is_valid()
	{
		$result = true;

		/*
		 Validation logics goes here
		*/

		if (!(isset($this->post['username']) && $this->post['username'] != NULL && $this->post['username'] != '' && $this->mvalidation->email($this->post['username']))) {
			array_push($this->validation_errors, "Username isn't a valid email address.");
			$result = false;
		}

		if (!(isset($this->post['password']) && $this->post['password'] != NULL && $this->post['password'] != '')) {
			array_push($this->validation_errors, 'Invalid Password.');
			$result = false;
		}

		return $result;
	}


	public function get_login($entity_type)
	{

		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('username', $this->post['username']);
		$this->db->where('password', $this->post['password']);
		$this->db->where('entity_type', $entity_type);
		$this->db->where('is_confirmed', 1);

		return $this->db->get()->row();
	}


	public function create($clinic_id, $entity_type)
	{
		$login_password = $this->utilityhandler->_salt($this->post["password"], $this->post['username']);
		$this->post['id'] = trim($this->mmodel->getGUID(), '{}');
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $clinic_id;
		$this->post['created_by'] = $clinic_id;
		$this->post['entity_id'] = $clinic_id;
		$this->post['password'] = $login_password;
		$this->post['entity_type'] = $entity_type;
		$this->post['is_confirmed'] = 0;
		$this->mmodel->insert($this->table, $this->post);
		return ($this->db->affected_rows() > 0);
	}

	public function get_login_for_entity($entity_id)
	{
		$result = $this->db
			->select('*')
			->from($this->table)
			->where('entity_id', $entity_id)
			->where('is_active', 1)
			->where('is_confirmed', 1)
			->where('is_deleted', 0)
			->get();

		return $result->row();
	}


	public function get_login_for_username($username)
	{
		$result = $this->db
			->select('*')
			->from($this->table)
			->where('username', $username)
			->where('is_active', 1)
			->where('is_confirmed', 1)
			->where('is_deleted', 0)
			->get();

		return $result->row();
	}


	public function check_valid_account($username = '')
	{
		$result = true;

		if ($this->mvalidation->email($username)) {

			$res = $this->db
				->select('entity_id,username')
				->from($this->table)
				->where('username', $username)
				->where('is_deleted', 0)
				->where('is_active', 1)
				->where('is_confirmed', 1)
				->get();

			if ($res->num_rows() == 0) {
				array_push($this->validation_errors, "Username not exists.");
				$result = false;
			}
		} else {
			array_push($this->validation_errors, "Username isn't a valid email address.");
			$result = false;
		}
		return $result;
	}

	public function reset_password()
	{
		$this->db
			->set('password', $this->post['password'])
			->set('updated', date("Y-m-d h:i:s"))
			->where('username', $this->post['username'])
			->where('is_deleted', 0)
			->where('is_active', 1)
			->where('is_confirmed', 1)
			->update($this->table);

		return ($this->db->affected_rows() > 0);
	}


}
