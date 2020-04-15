<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mpatient');
	}

	public function index()
	{
		echo "hello Patient";
	}


}
