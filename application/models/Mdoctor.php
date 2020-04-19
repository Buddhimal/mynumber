<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdoctor extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('mvalidation');
	}


	public function is_valid($post_array)
	{
		$validation_errors = array();

		if (!(isset($post_array['salutation']) &&  $post_array['salutation'] != NULL && $post_array['salutation'] != '')) {
			array_push($validation_errors, 'Invalid Salutation.');
		}
		if (!(isset($post_array['firstname']) &&  $post_array['firstname'] != NULL && $post_array['firstname'] != '')) {
			array_push($validation_errors, 'Invalid First Name.');
		}
		if (!(isset($post_array['lastname']) &&  $post_array['lastname'] != NULL && $post_array['lastname'] != '')) {
			array_push($validation_errors, 'Invalid Last Name.');
		}
		if (!(isset($post_array['slmc_reg_number']) &&  $post_array['slmc_reg_number'] != NULL && $post_array['slmc_reg_number'] != '')) {
			array_push($validation_errors, 'Invalid SLMC Reg Number.');
		}
		if (!(isset($post_array['email']) &&  $this->mvalidation->email($post_array['email']))) {
			array_push($validation_errors, 'Invalid Email.');
		}
		if (!(isset($post_array['device_mobile']) &&  $this->mvalidation->telephone($post_array['device_mobile']))) {
			array_push($validation_errors, 'Invalid Device Mobile.');
		}

		if(sizeof($validation_errors)>0){
			$result['validation_status'] = 0;
		} else{
			$result['validation_status'] = 1;
		}
		$result['validation_msg'] = $validation_errors;
		return $result;

	}


}
