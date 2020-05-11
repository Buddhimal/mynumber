<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mvalidation extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function email($email = '')
	{
		return preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email) === 1;
	}

	function telephone($tp = '')
	{
		$length = strlen($tp);
		return ($length == 10);
	}

	function already_exists($table, $column, $value)
	{
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($column, $value);
		$result = $this->db->get();
		return ($result->num_rows() > 0) ;
	}


	function valid_id($table, $value)
	{
		$this->db->select('id');
		$this->db->from($table);
		$this->db->where('id', $value);
		$result = $this->db->get();
		return ($result->num_rows() > 0) ;
	}

	function valid_time($time)
	{
		if (preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $time)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function valid_date($date)
	{
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


}
