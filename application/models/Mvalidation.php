<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mvalidation extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function email($email='')
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
	}

	function telephone($tp='')
	{
		$length = strlen($tp);
		return ( $length<=15) ? TRUE : FALSE;
	}


}
