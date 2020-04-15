<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SalesPerson extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Msalesperson');
	}

	public function index()
	{
		echo "hello Sales Person";
	}

}
