<?php


class Fcmsender
{
	public function send_fcm($data,$fcm_id)
	{
		$curl = curl_init();

//		$id_array = array('c8b91QBmTlOzXLV7XNFEcW:APA91bFzbS2xQDZYk7AdzLb46MwYdC6wDf4_SiFH0EmoWnx1sCJmsDob5GDmyPernqrSdr3oGTxW7zieDMuAIfjUAZmoCA_AYJFYUTGCNWm0E-qvYu0M4ucmkAAUmVRcSQyZFh1HvKj3');
//		$notification['title'] = "Your doctor is on his way to clinic";
//		$notification['body'] = "Your clinic session will be started at 04:30PM and your appointment number is 04.";
//
//		$data['title'] = "Your doctor is on his way to clinic";
//		$data['body'] = "Your clinic session will be started at 04:30PM and your appointment number is 04.";

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS => json_encode(array('registration_ids' => $fcm_id, 'priority' => 10, 'notification' => $data, 'data' => $data)),
			CURLOPT_HTTPHEADER => array(
				"Authorization: key=AAAAZIexVJk:APA91bEaS1mmqc56An3KNmRYi-9V1gTr-6AYbjjOBcOyk400nlmuQRkBXde73EY9H3zJPerRvCM5k5w_yeiHxZjgwC5u6D--9cRMZsW6ZS0S-ddqF4z55FAdbRx81Z4mMn7ancigAlAB",
				"Content-Type: application/json"
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return true;
//		echo $response;
	}
}
