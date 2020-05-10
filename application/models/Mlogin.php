<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mlogin extends CI_Model{

	public $validation_errors = array();
	private $post = array();
	protected $table = "muliti_user_login";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


	public function set_data($post_array)
	{
		$this->post = $post_array;
	}

	public function is_valid()
	{
		$result = true;

		/*
		 Validation logics goes here
		*/
		 if (!isset($this->post['password']) || empty($this->post['password']) ) {
		 	array_push($this->validation_errors, 'Invalid Clinic Name.');
			$result = false;
		}

		if ( !isset($this->post['username']) || $this->mvalidation->email($this->post['username']) ) {
			array_push($this->validation_errors, "Username isn't a valid email address");
			$result = false;
		}

		return $result;
	}


	public function get_login($entity_type){

		return $this->db->get_where( array("username"=>$this->post['username'], 'password' => $this->post['password'], 'entity_type'=> $entity_type , 'is_confirmed' => 1 ) );
	}

	/*
	*
	*/
	public function create($clinic_id,  $entity_type)
	{
		$login_password = $this->UtilityHandler->_salt($this->post["password"], $this->post['username']);
		$this->post['id'] = trim($this->mmodel->getGUID(), '{}');
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $doctor_id;
		$this->post['created_by'] = $doctor_id;
		$this->post['entity_id'] = $clinic_id;
		$this->post['password'] = $login_password;
		$this->post['entity_type'] = $entity_type;
		$this->post['is_confirmed'] = 0;
		$this->mmodel->insert($this->table, $this->post);
		return ($this->db->affected_rows() > 0);
	}


}