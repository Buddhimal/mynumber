<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'entities/EntityClinicSessionTask.php');

class Mclinicsessiontrans extends CI_Model
{

	public $validation_errors = array();
	private $post = array();
	protected $table = "clinic_session_trans";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
		$this->load->library('Messagesender');
		$this->load->library('Fcmsender');
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

	public function start_session($session_id)
	{
		$fcm_id = array();

		if ($this->check_session_already_updated($session_id, SessionStatus::START)) {

			$id = trim($this->mmodel->getGUID(), '{}');
			$this->post['id'] = $id;
			$this->post['clinic_date'] = DateHelper::slk_date();
			$this->post['clinic_session_id'] = $session_id;
			$this->post['action'] = SessionStatus::START;

			$additional_data['action'] = "start";
			$additional_data['action_datetime'] = date("Y-m-d H:i:s");

			$this->post['additional_data'] = json_encode($additional_data);
			$this->post['action_datetime'] = date("Y-m-d H:i:s");
			$this->post['is_deleted'] = 0;
			$this->post['is_active'] = 1;
			$this->post['updated'] = date("Y-m-d H:i:s");
			$this->post['created'] = date("Y-m-d H:i:s");
			$this->post['updated_by'] = $id;
			$this->post['created_by'] = $id;

			$this->mmodel->insert($this->table, $this->post);

			//sending sms
			if ($this->db->affected_rows() > 0) {

				//get full appointment details
				$appointments = $this->mclinicappointment->get_appointment_full_detail($session_id, DateHelper::slk_date());

				foreach ($appointments->result() as $patient) {
					$this->messagesender->send_sms($patient->patient_phone, SMSTemplate::StartSessionSMS((array)$patient));
					$fcm_id[] = $patient->firebase_id;
				}
				if ($appointments->num_rows() > 0)
					$this->fcmsender->send_fcm(FCMTemplate::StartSessionFCM((array)$patient), $fcm_id);
			}
		}

		return true;
	}

	//create two functions for start and finish because additional data can be changed in future
	public function finish_session($session_id)
	{
		if ($this->check_session_already_updated($session_id, SessionStatus::FINISHED)) {

			$id = trim($this->mmodel->getGUID(), '{}');
			$this->post['id'] = $id;
			$this->post['clinic_date'] = DateHelper::slk_date();
			$this->post['clinic_session_id'] = $session_id;
			$this->post['action'] = SessionStatus::FINISHED;

			$additional_data['action'] = "finished";
			$additional_data['action_datetime'] = date("Y-m-d H:i:s");

			$this->post['additional_data'] = json_encode($additional_data);
			$this->post['action_datetime'] = date("Y-m-d H:i:s");
			$this->post['is_deleted'] = 0;
			$this->post['is_active'] = 1;
			$this->post['updated'] = date("Y-m-d H:i:s");
			$this->post['created'] = date("Y-m-d H:i:s");
			$this->post['updated_by'] = $id;
			$this->post['created_by'] = $id;

			$this->mmodel->insert($this->table, $this->post);

		}

		return true;
	}

	public function cancel_session($session_id)
	{
		$last_status = $this->get_last_states_of_session($session_id, DateHelper::slk_date());
		$fcm_id = array();
		if ($last_status != SessionStatus::ON_THE_WAY) {

			if ($last_status != SessionStatus::CANCELED) {

				$id = trim($this->mmodel->getGUID(), '{}');
				$this->post['id'] = $id;
				$this->post['clinic_date'] = DateHelper::slk_date();
				$this->post['clinic_session_id'] = $session_id;
				$this->post['action'] = SessionStatus::CANCELED;

				$additional_data['action'] = "canceled";
				$additional_data['action_datetime'] = date("Y-m-d H:i:s");

				$this->post['additional_data'] = json_encode($additional_data);
				$this->post['action_datetime'] = date("Y-m-d H:i:s");
				$this->post['is_deleted'] = 0;
				$this->post['is_active'] = 1;
				$this->post['updated'] = date("Y-m-d H:i:s");
				$this->post['created'] = date("Y-m-d H:i:s");
				$this->post['updated_by'] = $id;
				$this->post['created_by'] = $id;

				$this->mmodel->insert($this->table, $this->post);

				//sending sms
				if ($this->db->affected_rows() > 0) {

					//get full appointment details
					$appointments = $this->mclinicappointment->get_appointment_full_detail($session_id, DateHelper::slk_date());

					foreach ($appointments->result() as $patient) {
						//update appointment main status
						$this->mclinicappointment->update_appointment_status($patient->appointment_id, AppointmentStatus::DOCTOR_CANCELED);
						$this->messagesender->send_sms($patient->patient_phone, SMSTemplate::CancelSessionSMS((array)$patient));
						$fcm_id[] = $patient->firebase_id;
					}
					if ($appointments->num_rows() > 0)
						$this->fcmsender->send_fcm(FCMTemplate::StartSessionFCM((array)$patient), $fcm_id);
				}
			}
		} else
			return false;

		return true;
	}


	//create two functions for start and finish because additional data can be changed in future
	public function send_on_the_way_session($session_id)
	{
		$fcm_id = array();
		if ($this->check_session_already_updated($session_id, SessionStatus::ON_THE_WAY)) {

			$id = trim($this->mmodel->getGUID(), '{}');
			$this->post['id'] = $id;
			$this->post['clinic_date'] = DateHelper::slk_date();
			$this->post['clinic_session_id'] = $session_id;
			$this->post['action'] = SessionStatus::ON_THE_WAY;

			$additional_data['action'] = "on the way";
			$additional_data['action_datetime'] = date("Y-m-d H:i:s");

			$this->post['additional_data'] = json_encode($additional_data);
			$this->post['action_datetime'] = date("Y-m-d H:i:s");
			$this->post['is_deleted'] = 0;
			$this->post['is_active'] = 1;
			$this->post['updated'] = date("Y-m-d H:i:s");
			$this->post['created'] = date("Y-m-d H:i:s");
			$this->post['updated_by'] = $id;
			$this->post['created_by'] = $id;

			$this->mmodel->insert($this->table, $this->post);

			//sending sms
			if ($this->db->affected_rows() > 0) {

				//get full appointment details
				$appointments = $this->mclinicappointment->get_appointment_full_detail($session_id, DateHelper::slk_date());

				foreach ($appointments->result() as $patient) {
					$this->messagesender->send_sms($patient->patient_phone, SMSTemplate::OnTheWaySMS((array)$patient));
					$fcm_id[] = $patient->firebase_id;
				}
				if ($appointments->num_rows() > 0)
					$this->fcmsender->send_fcm(FCMTemplate::OnTheWayFCM((array)$patient), $fcm_id);
			}

		}

		return true;
	}

	public function create()
	{
		$result = false;

		return $result;
	}

	public function get_last_states_of_session($session_id, $date)
	{
		$res = $this->db
			->select('action')
			->from($this->table)
			->where('clinic_session_id', $session_id)
			->where('clinic_date', $date)
			->where('is_active', 1)
			->where('is_deleted', 0)
			->order_by('created DESC, updated DESC')
			->limit(1)
			->get();

		if ($res->num_rows() > 0)
			return $res->row()->action;

		return SessionStatus::PENDING;
	}

	public function check_session_already_updated($session_id, $status)
	{

		$res = $this->db
			->select('*')
			->from($this->table)
			->where('clinic_session_id', $session_id)
			->where('clinic_date', DateHelper::slk_date())
			->where('action', $status)
			->where('is_active', 1)
			->where('is_deleted', 0)
			->get();
		return ($res->num_rows() == 0);
	}

	public function get_session_trans_by_action($session_id, $action)
	{
		$res = $this->db
			->select('*')
			->from($this->table)
			->where('clinic_session_id', $session_id)
			->where('action', $action)
			->where('clinic_date', DateHelper::slk_date())
			->where('is_active', 1)
			->where('is_deleted', 0)
			->get();

		if ($res->num_rows() > 0)
			return $res->row();
		else
			return null;


	}

	public function get_sessions_tasks_completed_within($clinic_id, $from)
	{
		$output = null;

		$result_set = $this->db->select("t.*,s.session_name")
			->from('clinic_session_trans as t')
			->join("clinic_session as s", "s.id = t.clinic_session_id")
			->where("t.action", SessionStatus::FINISHED)
			->where("t.action_datetime >= ", $from)
			->where("t.action_datetime < ", date("Y-m-d"))
			->where("t.is_deleted=0 and t.is_active=1")
			->where("s.clinic_id", $clinic_id)
			->get();

		// DatabaseFunction::last_query();

		if ($result_set->num_rows() > 0) {
			foreach ($result_set->result() as $session_data) {
				$output[] = new EntityClinicSessionTask($session_data);
			}
		}

		return $output;
	}

	public function get_sessions_tasks($clinic_id, $ids)
	{
		$output = null;

		$result_set = $this->db->select("t.*")
			->from("clinic_session_trans as t")
			->join("clinic_session as s", "s.id = t.clinic_session_id")
			->where_in("t.id ", $ids)
			->where("s.clinic_id", $clinic_id)
			->get();

		if ($result_set->num_rows() > 0) {
			foreach ($result_set->result() as $session_data) {
				$output[] = new EntityClinicSessionTask($session_data);
			}
		}

		return $output;
	}

}
