<?php


$this->ci =& get_instance();
$this->ci->load->database();




//region EntityTypes

define("PATIENT", 1);
define("CONSULTANT", 1);
define("SALEREP", 1);

//endregion


//region APIResponseCodes

define("SUCCESS", 2000);  // Api response status =200 & all completed successfully
define("SUCCESS_WITH_ERRORS", 2001);  // Api response status =200 & all completed with errors


define("INTERNAL_SERVER_ERROR", 5000);  // Api response status =500

define("BAD_REQUEST", 4000);  // Api response status =400 & all Validations Failed

define("UNAUTHORIZED", 4010);  // Api response status =401 & Unauthorized

define("METHOD_NOT_ALLOWED", 4050);  // Api response status =405 & method not allowed


//endregion




//region Set Const From Database

//$query = $this->ci->db->get('system_settings');

//foreach ($query->result() as $row)
//{
//	define($row->status_const,$row->status_id);
//}

//endregion


//class Enum_EntityType
//{
//	// public=0, consultant=1, salesrep=2
//	const Patient = 0;
//	const Consultant = 1;
//	const SaleRep = 2;
//
//
//}

