<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'entities/EntityClinicSession.php');

class Mclinicsession extends CI_Model
{

	public $validation_errors = array();
	private $post = array();
	protected $table = "clinic_session";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
		$this->load->model('mdoctor');
	}


	public function set_data($post_array)
	{
//		if (isset($post_array['day']))
//			$this->post['day'] = $post_array['day'];
        if (isset($post_array['consultant']))
            $this->post['consultant'] = $post_array['consultant'];
        if (isset($post_array['session_name']))
            $this->post['session_name'] = $post_array['session_name'];
        if (isset($post_array['session_description']))
            $this->post['session_description'] = $post_array['session_description'];
		if (isset($post_array['avg_time_per_patient']))
			$this->post['avg_time_per_patient'] = $post_array['avg_time_per_patient'];
		if (isset($post_array['max_patients']))
			$this->post['max_patients'] = $post_array['max_patients'];
//		if (isset($post_array['starting_time']))
//			$this->post['starting_time'] = $post_array['starting_time'];
//		if (isset($post_array['end_time']))
//			$this->post['end_time'] = $post_array['end_time'];
	}

	public function is_valid()
	{
		unset($this->validation_errors);
		$this->validation_errors = array();

		$result = true;

//		if (!(isset($this->post['day']) && $this->post['day'] != NULL && $this->post['day'] != '')) {
//			array_push($this->validation_errors, 'Invalid Day.');
//			$result = false;
//		}

//		if (!(isset($this->post['starting_time']) && $this->post['starting_time'] != NULL && $this->post['starting_time'] != '' && $this->mvalidation->valid_time($this->post['starting_time']) == TRUE)) {
//			array_push($this->validation_errors, 'Invalid Start Time.');
//			$result = false;
//		}

		if (!($this->post['consultant'] != NULL && $this->post['consultant'] != '')) {
			array_push($this->validation_errors, 'Invalid Consultant..');
			$result = false;
		} elseif ($this->mdoctor->valid_doctor($this->post['consultant']) == FALSE) {
			array_push($this->validation_errors, 'Consultant not match..');
			$result = false;
		}

        if (!(isset($this->post['session_name']) && $this->post['session_name'] != NULL && $this->post['session_name'] != '')) {
            array_push($this->validation_errors, 'Invalid Session Name..');
            $result = false;
        }

        if (!(isset($this->post['avg_time_per_patient']) && $this->post['avg_time_per_patient'] != NULL && $this->post['avg_time_per_patient'] != '' && $this->mvalidation->valid_time($this->post['avg_time_per_patient']) == TRUE)) {
            array_push($this->validation_errors, 'Invalid average time per patient.');
            $result = false;
        }

        if (!(isset($this->post['max_patients']) && $this->post['max_patients'] != NULL && $this->post['max_patients'] != '' )) {
            array_push($this->validation_errors, 'Invalid max patient.');
            $result = false;
        }

		return $result;
	}

	/*
	*
	*/
	public function create($clinic_id)
	{
		$result = null;

		$session_id = trim($this->mmodel->getGUID(), '{}');

		$this->post['id'] = $session_id;
		$this->post['clinic_id'] = $clinic_id;
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $session_id;
		$this->post['created_by'] = $session_id;

		$this->mmodel->insert($this->table, $this->post);

		if ($this->db->affected_rows() > 0) {
			$result = $this->get($session_id);
		}

		return $result;
	}


	public function get($id)
	{

		$query_result = $this->get_record($id);

        $sessions = new EntityClinicSession($query_result);
        $sessions->days = $this->mclinicsessiondays->get_days_by_session($sessions->id);
        $output[] = $sessions;

        return $output;
	}

	private function get_record($id)
	{

		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$this->db->where('is_deleted', 0);
		$this->db->where('is_active', 1);
		return $this->db->get()->row();
	}

	function valid_session($id)
	{
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$this->db->where('is_deleted', 0);
		$this->db->where('is_active', 1);
		$result = $this->db->get();

		return ($result->num_rows() > 0);
	}

	public function get_sessions($clinic_id)
	{
		$output = null;

		$all_sessions = $this->db
			->select('*')
			->from(sprintf("%s S", $this->table))
			->where(sprintf("S.clinic_id='%s' and S.is_deleted=0 and S.is_active=1", $clinic_id))
			->get();

		foreach ($all_sessions->result() as $session_data) {
			$output[] = new EntityClinicSession($session_data);
		}
		return $output;
	}

	public function get_sessions_for_day($clinic_id='',$date='')
	{
		$output = null;
		if ($date == '') {

			$day = date('N');
		} else{
			$day = date('N', strtotime($date));
		}

		$all_sessions=$this->db
			->select('c.*')
			->from('clinic_session as c')
            ->join('clinic_session_days as d','d.session_id=c.id')
			->where(sprintf("c.clinic_id='%s' and c.is_deleted=0 and c.is_active=1 and d.is_deleted=0 and d.is_active=1", $clinic_id))
			->where('d.day',$day)
			->get();

		foreach ($all_sessions->result() as $session_data) {
			$sessions = new EntityClinicSession($session_data);
            $sessions->days = $this->mclinicsessiondays->get_today_session($sessions->id,$day);
            $sessions->days->appointment_count = $this->mclinicappointment->get_appointment_count_for_today($sessions->id);
            $output[] = $sessions;
        }

        return $output;
	}

	public function get_sessions_for_consultant($clinic_id='',$consultant_id='')
	{

		$all_sessions=$this->db
			->select('*')
			->from($this->table)
			->where(sprintf("clinic_id='%s' and is_deleted=0 and is_active=1", $clinic_id))
			->where('consultant',$consultant_id)
			->get();

		foreach ($all_sessions->result() as $session_data) {
			$output[] = new EntityClinicSession($session_data);
		}
		return $output;
	}


}
