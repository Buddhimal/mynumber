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

	function index_get($id)
	{
		$this->response(array("value" => array("this is the GET response")), REST_Controller::HTTP_OK);


		$data = null;
		$this->load->entity("EntityConsultant", $data, 'consultant');
		//$this->response( array("value" => array( "this is the GET response")), REST_Controller::HTTP_OK);
		$this->response($this->consultant, REST_Controller::HTTP_OK);
	}

	public function index_post()
	{
		$input = $this->input->post('id');

		$this->response(array("value" => array("this is the POST response " . $input)), REST_Controller::HTTP_OK);
	}

	public function RegisterDoctor_post()
	{

		$method = $_SERVER['REQUEST_METHOD'];

		if ($method == 'POST') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				// Passing post array to the model.
				$this->mdoctor->set_data( $this->input->post() );

				// model it self will validate the input data
				if( $this->mdoctor->is_valid() ){

					// create the doctor record as the given data is valid
					$doctor = $this->mdoctor->create();

					if(!is_null($doctor)) {

						$response = new stdClass();

						$response->status = REST_Controller::HTTP_OK;
						$response->msg = 'New Doctor Added Successfully';
						$response->response = $doctor;
						$this->response($response, REST_Controller::HTTP_OK);
					}

				}else{

					$response['status'] = REST_Controller::HTTP_BAD_REQUEST;
					$response['msg'] = $this->mdoctor->validation_result[0];
					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
				}

			} else {
				$response['status'] = REST_Controller::HTTP_UNAUTHORIZED;
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}

		} else {
			$response['status'] = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}

	public function RegisterDoctor_get()
	{

		$this->response(array("value" => array("this is the Doctor response get")), REST_Controller::HTTP_OK);
	}

}
