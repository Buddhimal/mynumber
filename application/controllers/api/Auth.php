<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model("mmodel");
		$this->load->model("mlogin");
	}

	//region Index
	function index_get()
	{
		$response = new stdClass();
		$response->status = REST_Controller::HTTP_BAD_REQUEST;
		$response->msg = 'Invalid Request.';
		$response->error_msg = 'Invalid Request.';
		$response->response = NULL;
		$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
	}

	function index_post()
	{
		$response = new stdClass();
		$response->status = REST_Controller::HTTP_BAD_REQUEST;
		$response->msg = 'Invalid Request.';
		$response->error_msg = 'Invalid Request.';
		$response->response = NULL;
		$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
	}

	function index_put()
	{
		$response = new stdClass();
		$response->status = REST_Controller::HTTP_BAD_REQUEST;
		$response->msg = 'Invalid Request.';
		$response->error_msg = 'Invalid Request.';
		$response->response = NULL;
		$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
	}

	function index_delete()
	{
		$response = new stdClass();
		$response->status = REST_Controller::HTTP_BAD_REQUEST;
		$response->msg = 'Invalid Request.';
		$response->error_msg = 'Invalid Request.';
		$response->response = NULL;
		$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
	}
	//endregion


	function checkin_get(){

		$response = new stdClass();
		
		$check_auth_client = $this->mmodel->check_auth_client();
		if ($check_auth_client == true) {

			$inputs = $this->input->get();
			
			$this->load->library("UtilityHandler", null);
			$inputs['password'] = $this->UtilityHandler->_salt($inputs["password"], $inputs['username']);

			$this->mlogin->set_data($inputs);
			if($this->mlogin->is_valid()){

//				$consultant_login_data = $this->mlogin->get_login(Enum_EntityType::Consultant);
				$consultant_login_data = $this->mlogin->get_login(CONSULTANT);
				/**
					look for is_active
					look for is_deleted
					if everything ok then send back the Clinic Data ( clinic data + sessions list + consultants list + holiday list of the current year)
				*/
			}
			
		}


	}

}
