<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use CodeIgnitor\RESTfull\ResourceController;

class Doctor extends ResourceController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mdoctor');
	}

	public function index()
	{
		echo "hello Doctor";
	}

}
