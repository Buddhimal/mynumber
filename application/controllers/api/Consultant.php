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
		$this->load->model("mpublic");
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


	//region All API for Consultant
	public function RegisterConsultant_post()
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
					$response->msg = 'Validation Failed.';
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

	public function ConsultantByUniqueId_get()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'GET') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				$doctor = $this->mdoctor->get($this->input->get('id'));

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

	public function UpdateConsultant_put($doctor_id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'PUT') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				// Passing put array to the model.
				$this->mdoctor->set_data($this->put());

				// model it self will validate the input data
				if ($this->mdoctor->is_valid()) {

					// update the doctor record as the given data is valid
					$doctor = $this->mdoctor->update($doctor_id);

					if (!is_null($doctor)) {

						unset($mdoctor);

						$response->status = REST_Controller::HTTP_OK;
						$response->msg = 'Doctor Updated Successfully';
						$response->error_msg = NULL;
						$response->response = $doctor;
						$this->response($response, REST_Controller::HTTP_OK);
					} else {
						$response->status = REST_Controller::HTTP_OK;
						$response->msg = 'No Records to Update';
						$response->error_msg = NULL;
						$response->response = $doctor;
						$this->response($response, REST_Controller::HTTP_OK);
					}
				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->msg = 'Validation Failed.';
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
	//endregion


	//region All API for Public
	public function RegisterPublic_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'POST') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				// Passing post array to the model.
				$this->mpublic->set_data($this->input->post());

				// model it self will validate the input data
				if ($this->mpublic->is_valid()) {

					// create the doctor record as the given data is valid
					$public = $this->mpublic->create();

					if (!is_null($public)) {
						$response->status = REST_Controller::HTTP_OK;
						$response->msg = 'New Public Added Successfully';
						$response->error_msg = NULL;
						$response->response = $public;
						$this->response($response, REST_Controller::HTTP_OK);
					}
				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->msg = 'Validation Failed.';
					$response->response = NULL;
					$response->error_msg = $this->mpublic->validation_errors;
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

	public function PublicByUniqueId_get()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'GET') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				$public = $this->mpublic->get($this->input->get('id'));

				$response->status = REST_Controller::HTTP_OK;
				$response->msg = 'Public Details';
				$response->error_msg = NULL;
				$response->response = $public;
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

	public function UpdatePublic_put($public_id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'PUT') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				// Passing put array to the model.
				$this->mpublic->set_data($this->put());

				// model it self will validate the input data
				if ($this->mpublic->is_valid()) {

					// update the public record as the given data is valid
					$public = $this->mpublic->update($public_id);

					if (!is_null($public)) {

						$response->status = REST_Controller::HTTP_OK;
						$response->msg = 'Public Updated Successfully';
						$response->error_msg = NULL;
						$response->response = $public;
						$this->response($response, REST_Controller::HTTP_OK);
					} else {
						$response->status = REST_Controller::HTTP_OK;
						$response->msg = 'No Records to Update';
						$response->error_msg = NULL;
						$response->response = $public;
						$this->response($response, REST_Controller::HTTP_OK);
					}
				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->msg = 'Validation Failed.';
					$response->response = NULL;
					$response->error_msg = $this->mpublic->validation_errors;
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


	//endregion


}
