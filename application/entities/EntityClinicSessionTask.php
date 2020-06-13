<?php 

class EntityClinicSessionTask{

	public $id = null;
	public $clinic_date = null;
	public $clinic_session_id = null;
	public $action = null;
	public $action_datetime = null;
	public $aditional_data = null ; //:string/json, 
	public $is_deleted = null;
	public $is_active = null;
	public $updated = null;
	public $created = null;
	public $updated_by = null;
	public $created_by = null;

	public $total_appointments = null;
	public $total = null;
	public $appointments = array();
}



