<?php


class Messagesender
{
	public function send_otp($number,$msg)
	{
		$user = "94714102030";
		$password = "1923";
		$text = urlencode('MyNumber.lk OTP code : '.$msg);
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

	private function get_web_page($url)
	{
		$options = array(
			CURLOPT_RETURNTRANSFER => true, // return web page
			CURLOPT_HEADER => false, // don't return headers
			CURLOPT_TIMEOUT=>500,
		);

		$ch = curl_init($url);
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		$header = curl_getinfo($ch);
		curl_close($ch);

		return $content;
	}
}
