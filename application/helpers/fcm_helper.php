<?php


class FCMTemplate
{
	public static function OnTheWayFCM($data)
	{
		$data["title"] = "Your doctor is on his way to clinic";
		$data["body"] = 'Dr. ' . $data['doctor_name'] . ' is on his way to the clinic ' . $data['clinic_name'] . ' at ' . $data['clinic_city'] . '.';

		return $data;
	}

	public static function CancelSessionFCM($data)
	{
		$myDateTime = DateTime::createFromFormat('Y-m-d', $data['appointment_date']);
		$appointment_date = $myDateTime->format('d F Y');
		$myDateTime = DateTime::createFromFormat('H:i:s', $data['starting_time']);
		$appointment_time = $myDateTime->format('h:i A');

		$data["title"] = "Cancel your Appointment";
		$data["body"] = 'Your appointment No.' . $data['serial_number'] . ' with Dr. ' . $data['doctor_name'] . ' at Clinic ' . $data['clinic_name'] . ' ' . $data['clinic_city'] . ', on ' . $appointment_date . ' ' . $appointment_time . ' is canceled due to an inevitable reason.';

		return $data;
	}

	public static function StartSessionFCM($data)
	{
		$data["title"] = "Your doctor is start the session";
		$data["body"] = 'Dr. ' . $data['doctor_name'] . ' has arrived at clinic ' . $data['clinic_name'] . ' at ' . $data['clinic_city'] . '.';

		return $data;
	}

}
