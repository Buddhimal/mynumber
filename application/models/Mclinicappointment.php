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
	public function create()
	{

	}
}