<?php


class SMSSender{

    const mynumber_info = 'My Number';
}

class SMSType{

    const new_user_email = 1;
    const promotion_email = 2;
}


class SMSTemplate{

    function OnTheWaySMS($data)
    {
        return 'Ayubowan ' . $data['patient_name'] . '! Dr. '.$data['doctor_name'] .' is on his way to the '.$data['clinic_name'].' at '.$data['clinic_city'].'.';
    }

    function CancelSessionSMS($data)
    {
        return 'Ayubowan ' . $data['patient_name'] . '! Your appointment with Dr. '.$data['doctor_name'] .' at '.$data['clinic_name'].' at '.$data['clinic_city'].'.';
    }



}