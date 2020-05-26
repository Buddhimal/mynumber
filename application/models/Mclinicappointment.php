<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mclinicappointment extends CI_Model
{

	public $validation_errors = array();
	private $post = array();
	protected $table = "clinic_appointments";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
		$this->load->model('appointmentserialnumber');
		$this->load->model('mclinicappointmenttrans');
	}


	public function set_data($post_array)
	{
		if (isset($post_array['serial_number']))
			$this->post['serial_number'] = $post_array['serial_number'];
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
	public function create($patient_id, $session_id, $serial_number_id, $appointment_serial_number_id)
	{

		$this->db->trans_start();

		$result = null;

		$appointment_id = trim($this->mmodel->getGUID(), '{}');

		$this->post['id'] = $appointment_id;
		$this->post['session_id'] = $session_id;
		$this->post['appointment_date'] = date("Y-m-d");
		$this->post['serial_number_id'] = $serial_number_id;
		$this->post['patient_id'] = $patient_id;
//		$this->post['is_canceled'] = 0;
		$this->post['appointment_status'] = AppointmentStatus::PENDING;
		$this->post['appointment_status_updated'] = date("Y-m-d h:i:s");
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $appointment_id;
		$this->post['created_by'] = $appointment_id;

		$this->mmodel->insert($this->table, $this->post);

		if ($this->db->affected_rows() > 0) {

			//confirm number
			if ($this->appointmentserialnumber->confirm_number($appointment_serial_number_id)) {
				return $this->get($appointment_id);
			}
		}

		$this->db->trans_complete();
		return $result;
	}


	public function get($id)
	{
		$query_result = $this->get_record($id);
		return $query_result;
	}

	private function get_record($id)
	{
		$this->db->select('id, patient_id, session_id, serial_number_id,appointment_date');
		$this->db->from($this->table);
		$this->db->where('id', $id);
//		$this->db->where('appointment_status', AppointmentStatus::PENDING);
		$this->db->where('is_deleted', 0);
		$this->db->where('is_active', 1);
		return $this->db->get()->row();
	}


	public function get_next_appointment($session_id){

		$appointment = null;

		$res = $this->db->query("SELECT
											a.id,
											a.session_id,
											a.serial_number_id,
											a.patient_id 
										FROM
											clinic_appointments AS a
											INNER JOIN serial_number AS sn ON a.serial_number_id = sn.id 
										WHERE
											a.id NOT IN ((
												SELECT
													cat.clinic_appointment_id 
												FROM
													clinic_appointment_trans cat 
												)) 
											AND a.session_id = '".$session_id."' 
											AND a.appointment_date = '".date('Y-m-d')."' 
											AND a.appointment_status = ".AppointmentStatus::PENDING." 
											AND a.is_deleted = 0 
											AND a.is_active = 1 
										ORDER BY
											sn.serial_number ASC 
											LIMIT 1");

		if($res->num_rows()>0){
//			$appointment['appointment'] = $this->get($res->row()->id);
			$appointment['patient'] = $this->mpublic->get($res->row()->patient_id);
			$appointment['serial_number'] = $this->mserialnumber->get($res->row()->serial_number_id);
		}

		return $appointment;
	}

	public function update_appointment_status($appointment_id,$status){

		$result = false;

		$this->db
			->set('appointment_status', $status)
			->set('appointment_status_updated', date("Y-m-d h:i:s"))
			->set('updated', date("Y-m-d h:i:s"))
			->where('id', $appointment_id)
			->update($this->table);

		if ($this->db->affected_rows() > 0) {


			if ($this->mclinicappointmenttrans->create($appointment_id, $status)) {
				$result= true;
			}
		}
		return $result;

	}

    public function get_appointment_count_for_today($session_id='')
    {
        $this->db->select('id, patient_id, session_id, serial_number_id,appointment_date');
        $this->db->from($this->table);
        $this->db->where('session_id', $session_id);
		$this->db->where('appointment_status !=', AppointmentStatus::CANCELED);
        $this->db->where('is_deleted', 0);
        $this->db->where('is_active', 1);
        return $this->db->get()->num_rows();
    }


}
