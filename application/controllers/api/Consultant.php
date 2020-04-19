<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/REST_Controller.php');

/**
 *
 */
class Consultant extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("mmodel");
		$this->load->model("mdoctor");
	}

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

	public function RegisterDoctor_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'POST') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				// Passing post array to the model.
				$this->mdoctor->set_data($this->input->post());

				// model it self will validate the input data
				if ($this->mdoctor->is_valid()) {

					// create the doctor record as the given data is valid
					$doctor = $this->mdoctor->create();

					if (!is_null($doctor)) {
						$response->status = REST_Controller::HTTP_OK;
						$response->msg = 'New Doctor Added Successfully';
						$response->error_msg = NULL;
						$response->response = $doctor;
						$this->response($response, REST_Controller::HTTP_OK);
					}
				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->msg = 'New Doctor Added Successfully';
					$response->response = NULL;
					$response->error_msg = $this->mdoctor->validation_errors;
					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
				}
			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}
		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}


	public function DoctorByUniqueId_get()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'GET') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				$doctor = $this->mdoctor->get_doctor($this->input->get('id'));

				$response->status = REST_Controller::HTTP_OK;
				$response->msg = 'Doctor Details';
				$response->error_msg = NULL;
				$response->response = $doctor;
				$this->response($response, REST_Controller::HTTP_OK);


			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}
		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}

}
