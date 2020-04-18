<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mmodel extends CI_Model
{
	private $client_service = "frontend-client";
	private $auth_key = "simplerestapi";
	private $table = null;

	function __construct()
	{
		parent::__construct();

		$table = "doctor";
	}

	public function check_auth_client(){

		$header_client_service = $this->input->get_request_header('Client-Service', TRUE);
		$header_auth_key  = $this->input->get_request_header('Auth-Key', TRUE);

		if($header_client_service == $this->client_service && $header_auth_key == $this->auth_key){
			return true;
		} else {
			return false;
		}
	}

	public function create_consultant($data) {

		/*
		* validation should be caried out here and throw exceptions if any issues found on incoming data
		*/
		


		$this->db->insert($table, $data);
	}

}