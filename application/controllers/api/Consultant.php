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
		$this->load->model("mlogin");
		$this->load->model("mdoctor");
		$this->load->model("mpublic");
		$this->load->model("mclinic");
		$this->load->model("mlocations");
		$this->load->model("mconsultantpool");
		$this->load->model("mclinicsession");
		$this->load->model("mclinicholidays");
		$this->load->model("mclinicsessionsubstituteconsultant");
		$this->load->model("motpcode");
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


	public function SendVerificationCode_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();

		if ($method == 'POST') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				//code...

			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}

		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}



	//region All API for Consultant

	//	public function RegisterConsultant_post()
	//	{
	//		$method = $_SERVER['REQUEST_METHOD'];
	//		$response = new stdClass();
	//		if ($method == 'POST') {
	//
	//			$check_auth_client = $this->mmodel->check_auth_client();
	//
	//			if ($check_auth_client == true) {
	//
	//				// Passing post array to the model.
	//				$this->mdoctor->set_data($this->input->post());
	//
	//				// model it self will validate the input data
	//				if ($this->mdoctor->is_valid()) {
	//
	//					// create the doctor record as the given data is valid
	//					$doctor = $this->mdoctor->create();
	//
	//					if (!is_null($doctor)) {
	//						$response->status = REST_Controller::HTTP_OK;
	//						$response->msg = 'New Doctor Added Successfully';
	//						$response->error_msg = NULL;
	//						$response->response = $doctor;
	//						$this->response($response, REST_Controller::HTTP_OK);
	//					}
	//				} else {
	//					$response->status = REST_Controller::HTTP_BAD_REQUEST;
	//					$response->msg = 'Validation Failed.';
	//					$response->response = NULL;
	//					$response->error_msg = $this->mdoctor->validation_errors;
	//					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
	//				}
	//			} else {
	//				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
	//				$response->msg = 'Unauthorized';
	//				$response->response = NULL;
	//				$response->error_msg = 'Invalid Authentication Key.';
	//				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
	//			}
	//		} else {
	//			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
	//			$response->msg = 'Method Not Allowed';
	//			$response->response = NULL;
	//			$response->error_msg = 'Invalid Request Method.';
	//			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
	//		}
	//	}


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


	//region All API For Clinic

	public function CreateClinic_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'POST') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				$json_data = $this->post('json_data');

				// Passing post array to the model.
				$this->mclinic->set_data($json_data);

				// model it self will validate the input data
				if ($this->mclinic->is_valid()) {

					$this->mlocations->set_data($json_data);

					//Validate location data
					if ($this->mlocations->is_valid()) {

//						$this->db->trans_start();

						// create the Location record as the given data is valid
						$locations = $this->mlocations->create();

						if (!is_null($locations)) {
							// create the Clinic record as the given data is valid
							$clinic = $this->mclinic->create($locations->id);


							if (!is_null($clinic)) {

								$login_data['username'] = $json_data['email'];
								$login_data['password'] = $json_data["password"];
								$login_data['mobile'] = $json_data["device_mobile"];

								$this->mlogin->set_data($login_data);

								$login = $this->mlogin->create($clinic->id, EntityType::Consultant); // return true or false

								if ($login) {
									$this->motpcode->create($clinic->id, $login_data['mobile']);
								}

								$clinic->location = $locations;

								$response->status = REST_Controller::HTTP_OK;
								$response->status_code = APIResponseCode::SUCCESS;
								$response->msg = 'New Clinic Added Successfully';
								$response->error_msg = NULL;
								$response->response = $clinic;
								$this->response($response, REST_Controller::HTTP_OK);
							} else {
								$response->status = REST_Controller::HTTP_INTERNAL_SERVER_ERROR;
								$response->status_code = APIResponseCode::INTERNAL_SERVER_ERROR;
								$response->msg = NULL;
								$response->error_msg = 'Internal Server Error';
								$response->response = NULL;
								$this->response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
							}
						} else {
							$response->status = REST_Controller::HTTP_INTERNAL_SERVER_ERROR;
							$response->status_code = APIResponseCode::INTERNAL_SERVER_ERROR;
							$response->msg = NULL;
							$response->error_msg = 'Internal Server Error';
							$response->response = NULL;
							$this->response($response, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
						}

//						$this->db->trans_complete();
//
//						if ($this->db->trans_status() == FALSE) {
//							$this->db->trans_rollback();
//						} else {
//							$this->db->trans_commit();
//						}
					} else {
						$response->status = REST_Controller::HTTP_BAD_REQUEST;
						$response->status_code = APIResponseCode::BAD_REQUEST;
						$response->msg = 'Validation Failed.';
						$response->response = NULL;
						$response->error_msg = $this->mlocations->validation_errors;
						$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
					}

				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->status_code = APIResponseCode::BAD_REQUEST;
					$response->msg = 'Validation Failed.';
					$response->response = NULL;
					$response->error_msg = $this->mclinic->validation_errors;
					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
				}
			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}
		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}

	}

	public function ValidateOTP_put($clinic_id = '')
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'PUT') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				$this->motpcode->set_data($this->put('json_data'));


				if ($this->motpcode->is_valid($clinic_id)) {

					$response->status = REST_Controller::HTTP_OK;
					$response->status_code = APIResponseCode::SUCCESS;
					$response->msg = 'OTP Validation Successful..';
					$response->error_msg = NULL;
					$response->response = NULL;
					$this->response($response, REST_Controller::HTTP_OK);

				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->status_code = APIResponseCode::BAD_REQUEST;
					$response->msg = 'Validation Failed.';
					$response->response = NULL;
					$response->error_msg = $this->motpcode->validation_errors;
					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
				}
			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}
		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}

	public function ClinicByUniqueId_get($clinic_id = '')
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'GET') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				$clinic = $this->mclinic->get($clinic_id);
				$clinic->location = $this->mlocations->get($clinic->location);

				$response->status = REST_Controller::HTTP_OK;
				$response->status_code = APIResponseCode::SUCCESS;
				$response->msg = 'Clinic Details';
				$response->error_msg = NULL;
				$response->response = $clinic;
				$this->response($response, REST_Controller::HTTP_OK);


			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}
		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}

	public function RegisterConsultant_post($clinic_id = '')
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		$inserted_records = array();
		$validation_errors = array();
		if ($method == 'POST') {

			$json_data = ($this->post('json_data'));

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				if ($this->mclinic->valid_clinic($clinic_id)) {
					foreach ($json_data['substitute'] as $substitute) {

						// Passing post array to the model.
						$this->mdoctor->set_data($substitute);

						// model it self will validate the input data
						if ($this->mdoctor->is_valid()) {

							// create the doctor record as the given data is valid
							$doctor = $this->mdoctor->create();

							if (!is_null($doctor)) {

								if ($this->mconsultantpool->create($doctor->id, $clinic_id) == true) {
									$inserted_records[] = $doctor;
								}
							}
						} else {
							$errors['msg'] = 'Validation Failed.';
							$errors['request_data'] = $substitute;
							$errors['errors'] = $this->mdoctor->validation_errors;
							$validation_errors[] = $errors;
						}
					}
					$response->status = REST_Controller::HTTP_OK;
					$response->status_code = APIResponseCode::SUCCESS;
					$response->msg = 'Success';
					$response->clinic = $clinic_id;
					$response->substitutes = $inserted_records;
					$response->validation_errors = $validation_errors;
					$this->response($response, REST_Controller::HTTP_OK);
				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->status_code = APIResponseCode::BAD_REQUEST;
					$response->msg = 'Invalid Clinic Id';
					$response->request_data = $this->post();
					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
				}
			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}
		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}

	public function ConsultantByUniqueId_get($consultant_id = '')
	{

		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		if ($method == 'GET') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				$doctor = $this->mdoctor->get($consultant_id);

				$response->status = REST_Controller::HTTP_OK;
				$response->status_code = APIResponseCode::SUCCESS;
				$response->msg = 'Doctor Details';
				$response->error_msg = NULL;
				$response->response = $doctor;
				$this->response($response, REST_Controller::HTTP_OK);


			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}
		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}

	public function UpdateConsultant_put($doctor_id = '')
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
						$response->status_code = APIResponseCode::SUCCESS;
						$response->msg = 'Doctor Updated Successfully';
						$response->error_msg = NULL;
						$response->response = $doctor;
						$this->response($response, REST_Controller::HTTP_OK);
					} else {
						$response->status = REST_Controller::HTTP_OK;
						$response->status_code = APIResponseCode::SUCCESS;
						$response->msg = 'No Records to Update';
						$response->error_msg = NULL;
						$response->response = $doctor;
						$this->response($response, REST_Controller::HTTP_OK);
					}
				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->status_code = APIResponseCode::BAD_REQUEST;
					$response->msg = 'Validation Failed.';
					$response->response = NULL;
					$response->error_msg = $this->mdoctor->validation_errors;
					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
				}
			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}
		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}  //need to recheck

	public function AddClinicSessions_post($clinic_id = '')
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();
		$inserted_records = array();
		$validation_errors = array();

		if ($method == 'POST') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				if ($this->mclinic->valid_clinic($clinic_id)) {

					$json_data = ($this->post('json_data'));

					foreach ($json_data['session'] as $session) {

						// Passing post array to the model.
						$this->mclinicsession->set_data($session);

						// model it self will validate the input data
						if ($this->mclinicsession->is_valid()) {

							// create the doctor record as the given data is valid
							$clinic_session = $this->mclinicsession->create($clinic_id);

							$inserted_records[] = $clinic_session;

						} else {
							$errors['msg'] = 'Validation Failed.';
							$errors['request_data'] = $session;
							$errors['errors'] = $this->mclinicsession->validation_errors;
							$validation_errors[] = $errors;
						}
					}
					$response->status = REST_Controller::HTTP_OK;
					$response->status_code = APIResponseCode::SUCCESS;
					$response->msg = 'Success';//				$response->error_msg = NULL;
					$response->sessions = $inserted_records;
					$response->validation_errors = $validation_errors;
					$this->response($response, REST_Controller::HTTP_OK);

				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->status_code = APIResponseCode::BAD_REQUEST;
					$response->msg = 'Invalid Clinic Id';
					$response->request_data = $this->post();
					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
				}

			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}

		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}

	public function AddHolidays_post($clinic_id = '')
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();

		if ($method == 'POST') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				if ($this->mclinic->valid_clinic($clinic_id)) {

					$this->mclinicholidays->set_data($this->post('json_data'));

					//Validate location data
					if ($this->mclinicholidays->is_valid()) {


						// create the holiday record as the given data is valid
						$holiday = $this->mclinicholidays->create($clinic_id);

						if (!is_null($holiday)) {
							$response->status = REST_Controller::HTTP_OK;
							$response->status_code = APIResponseCode::SUCCESS;
							$response->msg = 'New Holiday Added Successfully';
							$response->error_msg = NULL;
							$response->response = $holiday;
							$this->response($response, REST_Controller::HTTP_OK);
						}
					} else {
						$response->status = REST_Controller::HTTP_BAD_REQUEST;
						$response->status_code = APIResponseCode::BAD_REQUEST;
						$response->msg = 'Validation Failed.';
						$response->response = NULL;
						$response->error_msg = $this->mclinicholidays->validation_errors;
						$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
					}


				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->status_code = APIResponseCode::BAD_REQUEST;
					$response->msg = 'Invalid Clinic Id';
					$response->request_data = $this->post();
					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
				}

			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}

		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}

	public function StartSession_put($clinic_id = '', $session_id = '')
	{
		$method = $_SERVER['REQUEST_METHOD'];
		$response = new stdClass();

		if ($method == 'PUT') {

			$check_auth_client = $this->mmodel->check_auth_client();

			if ($check_auth_client == true) {

				if ($this->mclinic->valid_clinic($clinic_id)) {

					if ($this->mclinicsession->valid_session($session_id)) {

						$this->mclinicsessionsubstituteconsultant->set_data($this->put('json_data'));

						if ($this->mclinicsessionsubstituteconsultant->is_valid()) {


							// create the holiday record as the given data is valid
							$holiday = $this->mclinicsessionsubstituteconsultant->create($session_id);

							if (!is_null($holiday)) {
								$response->status = REST_Controller::HTTP_OK;
								$response->status_code = APIResponseCode::SUCCESS;
								$response->msg = 'New Session Added Successfully';
								$response->error_msg = NULL;
								$response->response = $holiday;
								$this->response($response, REST_Controller::HTTP_OK);
							}
						} else {
							$response->status = REST_Controller::HTTP_BAD_REQUEST;
							$response->status_code = APIResponseCode::BAD_REQUEST;
							$response->msg = 'Validation Failed.';
							$response->response = NULL;
							$response->error_msg = $this->mclinicsessionsubstituteconsultant->validation_errors;
							$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
						}
					} else {
						$response->status = REST_Controller::HTTP_BAD_REQUEST;
						$response->status_code = APIResponseCode::BAD_REQUEST;
						$response->msg = 'Invalid Session Id';
						$response->request_data = $this->post();
						$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
					}


				} else {
					$response->status = REST_Controller::HTTP_BAD_REQUEST;
					$response->status_code = APIResponseCode::BAD_REQUEST;
					$response->msg = 'Invalid Clinic Id';
					$response->request_data = $this->post();
					$this->response($response, REST_Controller::HTTP_BAD_REQUEST);
				}

			} else {
				$response->status = REST_Controller::HTTP_UNAUTHORIZED;
				$response->status_code = APIResponseCode::UNAUTHORIZED;
				$response->msg = 'Unauthorized';
				$response->response = NULL;
				$response->error_msg = 'Invalid Authentication Key.';
				$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
			}

		} else {
			$response->status = REST_Controller::HTTP_METHOD_NOT_ALLOWED;
			$response->status_code = APIResponseCode::METHOD_NOT_ALLOWED;
			$response->msg = 'Method Not Allowed';
			$response->response = NULL;
			$response->error_msg = 'Invalid Request Method.';
			$this->response($response, REST_Controller::HTTP_METHOD_NOT_ALLOWED);
		}
	}


	//endregion


}
