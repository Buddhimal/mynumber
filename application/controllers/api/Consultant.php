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
		$this->load->model("Mdoctor");
	}
	
	function index_get($id) {
		$this->response( array("value" => array( "this is the response")), REST_Controller::HTTP_OK);
	}

}