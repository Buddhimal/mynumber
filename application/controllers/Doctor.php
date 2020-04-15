<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mdoctor');
	}

	public function index()
	{
		echo "hello Doctor";
	}

}
