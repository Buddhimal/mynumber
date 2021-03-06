<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'entities/EntityClinicPendingPaymentDetails.php');

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
        if (isset($post_array['serial_number_id']))
            $this->post['serial_number_id'] = $post_array['serial_number_id'];
        if (isset($post_array['name']))
            $this->post['patient_name'] = $post_array['name'];
        if (isset($post_array['address']))
            $this->post['patient_address'] = $post_array['address'];
        if (isset($post_array['phone']))
            $this->post['patient_phone'] = $post_array['phone'];
        if (isset($post_array['is_myself']))
            $this->post['is_myself'] = $post_array['is_myself'];
    }

    public function is_valid()
    {
        $result = true;

        if (!(isset($this->post['serial_number_id']) && $this->post['serial_number_id'] != NULL && $this->post['serial_number_id'] != '')) {
            array_push($this->validation_errors, 'Invalid serial number.');
            $result = false;
        }
        if (!(isset($this->post['patient_name']) && $this->post['patient_name'] != NULL && $this->post['patient_name'] != '')) {
            array_push($this->validation_errors, 'Invalid patient name.');
            $result = false;
        }
        if (!(isset($this->post['patient_address']) && $this->post['patient_address'] != NULL && $this->post['patient_address'] != '')) {
            array_push($this->validation_errors, 'Invalid patient address.');
            $result = false;
        }
        if (!(isset($this->post['patient_phone']) && $this->post['patient_phone'] != NULL && $this->post['patient_phone'] != '')) {
            array_push($this->validation_errors, 'Invalid patient phone.');
            $result = false;
        }

        return $result;
    }

    /*
    *
    */
    public function create($patient_id, $session_id, $appointment_serial_number_id)
    {

        $this->db->trans_start();

        $result = null;

        //confirm number
        if ($this->appointmentserialnumber->confirm_number($appointment_serial_number_id)) {

            $appointment_id = trim($this->mmodel->getGUID(), '{}');

            $this->post['id'] = $appointment_id;
            $this->post['session_id'] = $session_id;
            $this->post['appointment_date'] = date("Y-m-d");
//		$this->post['serial_number_id'] = $serial_number_id;
            $this->post['patient_id'] = $patient_id;
            // $this->post['is_canceled'] = 0;
            $this->post['appointment_status'] = AppointmentStatus::PENDING;
            $this->post['appointment_charge'] = Payments::DEFAULT_CHARGE;
            $this->post['appointment_status_updated'] = date("Y-m-d H:i:s");
            $this->post['is_canceled'] = 0;
            $this->post['is_deleted'] = 0;
            $this->post['is_active'] = 1;
            $this->post['updated'] = date("Y-m-d H:i:s");
            $this->post['created'] = date("Y-m-d H:i:s");
            $this->post['updated_by'] = $appointment_id;
            $this->post['created_by'] = $appointment_id;

            //create appointment
            $this->mmodel->insert($this->table, $this->post);

            if ($this->db->affected_rows() > 0) {
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
        // $this->db->where('appointment_status', AppointmentStatus::PENDING);
        $this->db->where('is_deleted', 0);
        $this->db->where('is_active', 1);
        return $this->db->get()->row();
    }

    public function get_next_appointment($clinic_id, $session_id, $patient_id = '')
    {
        $slk_date = DateHelper::slk_date();
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
											AND a.session_id = '" . $session_id . "' 
											AND a.appointment_date = '" . $slk_date . "' 
											AND a.appointment_status = " . AppointmentStatus::PENDING . " 
											AND a.is_deleted = 0 
											AND a.is_active = 1 
										ORDER BY
											sn.serial_number ASC 
											LIMIT 1");

        // DatabaseFunction::last_query();

        if ($res->num_rows() > 0) {
            $appointment['id'] = $res->row()->id;
            $appointment['default_charge'] = Payments::DEFAULT_CHARGE;
            $appointment['patient'] = $this->mpublic->get($res->row()->patient_id);
            $appointment['serial_number'] = $this->mserialnumber->get($res->row()->serial_number_id);
            if (!is_null($patient_id))
                $appointment['payment_dues'] = $this->get_payment_dues($clinic_id, $patient_id);
            else
                $appointment['payment_dues'] = null;
        }

        return $appointment;
    }

    public function update_appointment_status($appointment_id, $status)
    {

        // $result = false;
        $this->db
            ->set('appointment_status', $status)
            ->set('appointment_status_updated', date("Y-m-d H:i:s"))
            ->set('updated', date("Y-m-d H:i:s"))
            ->where('id', $appointment_id)
            ->where('appointment_status !=', $status)//this is add to skip updating same status twice. for better validation if call next_number() two times with same appointment number
            ->update($this->table);

        if ($this->db->affected_rows() > 0) {
            if ($this->mclinicappointmenttrans->create($appointment_id, $status)) {
                $result = true;
            }
        } else $result = true;
        return $result;

    }

    public function get_appointment_count_for_today($session_id = '')
    {
        $this->db->select('id, patient_id, session_id, serial_number_id,appointment_date');
        $this->db->from($this->table);
        $this->db->where('session_id', $session_id);
        $this->db->where('appointment_date', DateHelper::slk_date());
        $this->db->where('appointment_status !=', AppointmentStatus::CANCELED);
        $this->db->where('is_deleted', 0);
        $this->db->where('is_active', 1);
        return $this->db->get()->num_rows();
    }

    public function get_appointment_count($session_id, $status)
    {
        $res = $this->db
            ->select('*')
            ->from($this->table)
            ->where('session_id', $session_id)
            ->where('appointment_date', DateHelper::slk_date())
            ->where('appointment_status', $status)
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        return $res->num_rows();
    }

    public function get_cumulative_amount($session_id)
    {

        $utc_date = DateHelper::utc_date(date("Y-m-d"));

        $res = $this->db
            ->select('COALESCE(sum(appointment_charge),0) as cumulative_amount')
            ->from($this->table)
            ->where('session_id', $session_id)
            ->where('appointment_date', DateHelper::slk_date())
            ->where("(appointment_status =" . AppointmentStatus::CONSULTED . " OR (appointment_status=" . AppointmentStatus::PAYMENT_COLLECT . " AND CAST(appointment_status_updated AS DATE) ='" . date("Y-m-d") . "')  )")
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        return $res->row()->cumulative_amount;
    }

    public function get_payment_dues($clinic_id, $patient_id)
    {
        //check if current session only or all the sessions with the same clinic

        $output = null;

        $res = $this->db
            ->select('a.appointment_date,a.appointment_charge')
            ->from('clinic_appointments as a')
            ->join('clinic_session as s', 's.id=a.session_id')
            ->where('a.patient_id', $patient_id)
            ->where('s.clinic_id', $clinic_id)
            ->where('a.appointment_status', AppointmentStatus::PENDING)
            ->where('a.appointment_date !=', DateHelper::slk_date())
            ->where('a.is_active', 1)
            ->where('s.is_active', 1)
            ->where('a.is_deleted', 0)
            ->where('s.is_deleted', 0)
            ->get();

        foreach ($res->result() as $due) {
            $output[] = $due;
        }
        return $output;
    }

    public function get_consulted_appoinments_for($clinic_id, $sessions)
    {

        if (!isset($sessions) || empty($sessions)) {
            throw new Exception("Empty Sessions list");
        }

        $output = new EntityClinicPendingPaymentDetails();

        $grand_total = 0;
        foreach ($sessions as $session_task) {

            $result_set = $this->db->select("count(t.id) as appointment_count, sum(a.appointment_charge) as session_total, sum(a.doctors_pay) as commission, sum(a.net_pay) as net_amount")
                ->from("$this->table a")
                ->join("clinic_appointment_trans t", "t.clinic_appointment_id = a.id")
                ->where( "a.session_id", $session_task->clinic_session_id )
                ->where( "a.is_active = 1 and a.is_deleted = 0 ")
                ->where_in("a.appointment_status", array(AppointmentStatus::CONSULTED, AppointmentStatus::PAYMENT_COLLECT))
                ->group_by("a.session_id")
                ->get();

            // DatabaseFunction::last_query();

            if ($result_set->num_rows() > 0) {
                //removed class instantiation here

                $session_task->total_appointments = $result_set->row('appointment_count');
                $session_task->total = $result_set->row('session_total');
                $session_task->commission = $result_set->row('commission');
                $session_task->net_amount = $result_set->row('net_amount');

                $output->add_session($session_task);
            }
        }

        return $output;
    }

    public function get_appointment_full_detail($session_id,$appointment_date)
    {
        $day = DateHelper::utc_day();

        $res=$this->db
            ->query("SELECT
                            ca.id,
                            p.firebase_id,
                            ca.id as appointment_id,
                            ca.patient_name,
                            ca.patient_address,
                            ca.patient_phone,
                            CONCAT(  d.first_name, ' ', d.last_name ) AS doctor_name,
                            c.clinic_name,
                            l.city AS clinic_city,
                            ca.appointment_date,
                            sn.serial_number,
                            sd.starting_time 
                        FROM
                            clinic_appointments AS ca
                            INNER JOIN `public` AS p on p.id=ca.patient_id and p.is_active=1 AND p.is_deleted=0
                            INNER JOIN clinic_session AS s ON ca.session_id = s.id
                            INNER JOIN doctor AS d ON s.consultant = d.id
                            INNER JOIN serial_number AS sn ON ca.serial_number_id = sn.id
                            INNER JOIN clinic_session_days AS sd ON s.id = sd.session_id 	
                            INNER JOIN clinic AS c ON c.id=s.clinic_id 
                            INNER JOIN locations AS l ON l.id = c.location_id
                        WHERE 
                            $day=sd.day
                            AND p.is_clinic=0
                            AND s.id='$session_id'
                            AND ca.appointment_date='$appointment_date'
                            AND ca.is_canceled=0
                            AND ca.is_active=1
                            AND ca.is_deleted=0
                            AND d.is_active=1
                            AND d.is_deleted=0
                            AND sn.is_active=1
                            AND sn.is_deleted=0
                            AND sd.is_active=1
                            AND sd.is_deleted=0
                            AND c.is_active=1
                            AND c.is_deleted=0
                            AND l.is_active=1
                            AND l.is_deleted=0                        
                        ");

        return $res;


    }

    public function get_appointment_patients($clinic_id,$from,$to){

    	$res= $this->db->query("SELECT
									public.salutation,
									clinic_appointments.patient_name as first_name,
									'' as last_name,
									clinic_appointments.patient_phone 
								FROM
									clinic_appointments
									INNER JOIN clinic_session ON clinic_appointments.session_id = clinic_session.id
									INNER JOIN public ON clinic_appointments.patient_id = public.id 
								WHERE
									clinic_appointments.is_canceled = 0 
									AND clinic_session.clinic_id = '$clinic_id'
									AND clinic_appointments.appointment_status NOT IN ( 0, 4, 7 ) 
									AND clinic_appointments.appointment_date BETWEEN '$from' 
									AND '$to'");
    	return $res->result();
	}

    public function get_appointment_patients_for_session($clinic_id,$on, $session_id){

    	$res= $this->db->query("SELECT
    								public.salutation,
    								clinic_appointments.patient_name as first_name,
    								'' as last_name,
    								clinic_appointments.patient_phone 
    							FROM
    								clinic_appointments
    								INNER JOIN clinic_session ON clinic_appointments.session_id = clinic_session.id
    								INNER JOIN public ON clinic_appointments.patient_id = public.id 
    							WHERE
    								clinic_appointments.is_canceled = 0 
    								AND clinic_session.clinic_id = '$clinic_id'
    								AND clinic_appointments.appointment_status NOT IN ( 0, 4, 7 ) 
    								AND clinic_appointments.appointment_date = '$on' 
    								AND clinic_appointments.session_id = '$session_id'");
    	return $res->result();
	}

}
