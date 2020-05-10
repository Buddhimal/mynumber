<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/REST_Controller.php');

class Auth extends REST_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model("mmodel");
		$this->load->model("mlogin");
		$this->load->model("mclinic");
		$this->load->model("mclinicholidays");
		$this->load->model("mclinicsession");
		$this->load->model("mdoctor");
		$this->load->library('utilityhandler');

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
		$response->msg = 'Invalid Request received to Auth Controller.';
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


	function checkin_post()
	{

		$response = new stdClass();

		try {

			$check_auth_client = $this->mmodel->check_auth_client();
			if ($check_auth_client == true) {

				$inputs = $this->post('json_data');

//				$this->load->library("UtilityHandler", null);
//				$inputs['password'] = $this->utilityhandler->_salt($inputs["password"], $inputs['username']);

				$this->mlogin->set_data($inputs);
				if ($this->mlogin->is_valid()) {

					$this->mlogin->post['password']=$this->utilityhandler->_salt($inputs["password"], $inputs['username']);

					$consultant_login_data = $this->mlogin->get_login(EntityType::Consultant);

					if ($consultant_login_data == NULL)
						throw new Exception("Account not found");

					if ($consultant_login_data->is_deleted == true)
						throw new Exception("Trying to access deleted account");

					if ($consultant_login_data->is_active===0)
						throw new Exception("Trying to access inactive account");

					$clinic = $this->mclinic->get($consultant_login_data->entity_id);
					$clinic->holidays = $this->mclinicholidays->get_holidays($clinic->id);

//					$clinic->sessions = $this->mclinicsession->get_sessions($clinic->id);  //issues found
//					$clinic->consultants = $this->mdoctor->get_consultants($clinic->id);   //issues found

					//Sending back the reponse
					$response->status = REST_Controller::HTTP_OK;
					$response->msg = 'Login Successfull';
					$response->error_msg = null;
					$response->response = $clinic;

				} else {
					// Either username is empty or not an email or else password is empty
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->msg = 'Invalid Request.';
					$response->error_msg = $this->mlogin->validation_errors;
					$response->response = NULL;
				}
			}
		} catch (Exception $ex) {
			$response->status = REST_Controller::HTTP_BAD_REQUEST;
			$response->msg = 'Failed to serve your request';
			$response->error_msg = $ex->getMessage();
			$response->response = NULL;
		}

		$this->response($response, $response->status);
	}

}
