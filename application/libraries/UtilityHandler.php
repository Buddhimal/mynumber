<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class UtilityHandler{


	function _salt($password, $username){
		return md5(sprintf("%s+%s", $password, substr($username, 0,3)));
	}


}
