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
	}
	
	function index_get($id) {
		$this->response( array("value" => array( "this is the GET response")), REST_Controller::HTTP_OK);
	}

	public function index_post()
	{
		$input = $this->input->post('id');

		$this->response(array("value" => array( "this is the POST response " .$input )), REST_Controller::HTTP_OK);
	}

	public function RegisterDoctor_post(){

		$method = $_SERVER['REQUEST_METHOD'];

		if($method == 'POST') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if($check_auth_client == true) {

				$doctor_id = trim(com_create_guid(), '{}');
				$doctor_data = $this->input->post();
				$doctor_data['id'] = $doctor_id;

//				$this->mmodel->insert('doctor', $doctor_data);


				$response['status'] = REST_Controller::HTTP_OK;
				$response['doctor_id'] = $doctor_id;
				$response['msg'] = 'New Doctor Added Successfully';


				$this->response($response, REST_Controller::HTTP_OK);
			} else{
				$response['status'] = REST_Controller::HTTP_UNAUTHORIZED;
				$this->response($response,REST_Controller::HTTP_UNAUTHORIZED);

			}
		} else {
			$response['status'] = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$this->response($response,REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}

	public function RegisterDoctor_get(){

		$this->response(array("value" => array( "this is the Doctor response get" )), REST_Controller::HTTP_OK);
	}

}
