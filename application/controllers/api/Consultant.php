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

		$data = null;
		$this->load->entity("EntityConsultant", $data, 'consultant');
		//$this->response( array("value" => array( "this is the GET response")), REST_Controller::HTTP_OK);
		$this->response( $this->consultant, REST_Controller::HTTP_OK); 
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
				$post = $this->input->post();

				/*
				POSTs

				salutation,
				firstname,
				lastname,
				wellknownas,
				contact_telephone,
				contact_mobile,
				device_mobile,
				email,
				specialities,
				slmc_reg_number
				consulting_hospitals
				*/

				/*
				id:guid, salutation:string(5), first_name:text, last_name:text, nic:varchar(20), contact_telephone:varchar(15), contact_mobile, device_mobile, email:text,  known_name:text, location:guid, specialities:json, doctor_code:guid, is_deleted:bool, is_active:bool, updated:datetime, created:datetime, updated_by:guid, created_by:guid
				*/


				// $this->mmodel->insert('doctor', $doctor_data);
				// select the inserted record, 
				// instantiate consultant as follows
				// $this->load->entity("EntityConsultant", , 'consultant');
				// $this->response($this->consultant, REST_Controller::HTTP_OK);


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
