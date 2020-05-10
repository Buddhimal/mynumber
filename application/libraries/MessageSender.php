<?php


class MessageSender
{
	public function send_msg($number,$msg)
	{
		$user = "94714102030";
		$password = "1923";
		$text = urlencode($msg);
		$to = $number;

		$baseurl ="http://www.textit.biz/sendmsg";
		$url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
		$ret = $this->get_web_page($url);
		$res= explode(":",$ret);


		if (trim($res[0]) == "OK") {
			return true;
		} else {
			return false;
		}

	}
}
