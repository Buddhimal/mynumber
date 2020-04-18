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


				$doctor_data['id']=$doctor_id;
				$doctor_data['salutation']=$this->input->post('salutation');
				$doctor_data['first_name']=$this->input->post('firstname');
				$doctor_data['last_name']=$this->input->post('lastname');
				$doctor_data['known_name']=$this->input->post('wellknownas');
				$doctor_data['contact_telephone']=$this->input->post('telephone');
				$doctor_data['email']=$this->input->post('email');
				$doctor_data['specialities']=$this->input->post('specialities');
				$doctor_data['slmc_reg_number']=$this->input->post('slmc_reg_number');
				$doctor_data['consulting_hospitals']=$this->input->post('consulting_hospitals');
				$doctor_data['is_deleted']=0;
				$doctor_data['is_active']=1;
				$doctor_data['updated']=date("Y-m-d h:i:s");
				$doctor_data['created']=date("Y-m-d h:i:s");
				$doctor_data['updated_by']='';
				$doctor_data['created_by']='';


				$this->mmodel->insert('doctor', $doctor_data);
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
