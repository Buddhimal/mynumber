<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Appointmentserialnumber extends CI_Model
{
	public $validation_errors = array();
	private $post = array();
	protected $table = "appointment_serial_number";

	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


	public function set_data($post_array)
	{

	}

	public function is_valid()
	{

		unset($this->validation_errors);
		$this->validation_errors = array();

		$result = true;

		return $result;
	}


	public function create()
	{
		$result = null;

		$appointment_id = trim($this->mmodel->getGUID(), '{}');

		$this->post['id'] = $appointment_id;
		$this->post['is_deleted'] = 0;
		$this->post['is_active'] = 1;
		$this->post['is_confirmed'] = 0;
		$this->post['appointment_date'] = date("Y-m-d");
		$this->post['serial_number_id'] = '';//call the function
		$this->post['issued_at'] = date("Y-m-d h:i:s");
		$this->post['expire_at'] = date('Y-m-d h:i:s', strtotime('+3 minutes', strtotime($this->post['issued_at'])));
		$this->post['updated'] = date("Y-m-d h:i:s");
		$this->post['created'] = date("Y-m-d h:i:s");
		$this->post['updated_by'] = $appointment_id;
		$this->post['created_by'] = $appointment_id;

		$this->mmodel->insert($this->table, $this->post);

		if ($this->db->affected_rows() > 0) {
			$result = $this->get($appointment_id);
		}

		return $result;
	}

	public function get_next_available_number($patient_id = '', $session_id = '')
	{
		$res = $this->db
			->select('serial_number_id')
			->from($this->table)
			->where('patient_id', $patient_id)
			->where('session_id', $session_id)
			->where('expire_at >', date("Y-m-d h:i:s"))
			->where('is_confirmed', 0)
			->where('is_active', 1)
			->where('is_deleted', 0)
			->limit(1)
			->order_by('issued_at', 'DESC')
			->get()->row();

		if ($res->serial_number_id == null) {

			//generate new number

			$res = $this->db
				->query("SELECT
								sn.id AS serial_number_id,
								sn.serial_number 
							FROM
								serial_number AS sn 
							WHERE
								sn.is_active = 1 
								AND sn.is_deleted = 0 
								AND sn.id NOT IN (
								SELECT
									asn.serial_number_id 
								FROM
									appointment_serial_number AS asn 
								WHERE
									( asn.is_confirmed = 1 OR asn.expire_at < CURRENT_TIMESTAMP () ) 
									AND asn.appointment_date = CAST( CURRENT_DATE () AS DATE ) 
									AND asn.is_active = 1 
									AND asn.is_deleted = 0 
									AND asn.session_id='$session_id'
								) 
							ORDER BY
								serial_number ASC 
								LIMIT 1")
				->get()->row();
			return $res->serial_number_id;
		} else {
			return $res->serial_number_id;
		}

	}


	public function get($id)
	{
		$query_result = $this->get_record($id);
		return new EntityConsultant($query_result);
	}

	private function get_record($id)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}


}
