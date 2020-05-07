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
		return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
	}

	function telephone($tp = '')
	{
		$length = strlen($tp);
		return ($length <= 15) ? TRUE : FALSE;
	}

	function already_exists($table, $column, $value)
	{
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($column, $value);

		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	function valid_id($table, $value)
	{
		$this->db->select('id');
		$this->db->from($table);
		$this->db->where('id', $value);

		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function valid_time($time)
	{
		if (preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $time)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function valid_date()
	{

	}


}
