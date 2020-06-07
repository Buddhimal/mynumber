<?php

class DateHelper
{
    public static function utc_date($date)
    {
        $minutes_to_add = 330;
        $date = new DateTime($date);
        $date->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        return $date->format('Y-m-d');
    }

    public static function utc_datetime($date)
    {
        $minutes_to_add = 330;
        $date = new DateTime($date);
        $date->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        return $date->format('Y-m-d H:i:s');
    }

    public static function utc_time($date)
    {
        $minutes_to_add = 330;
        $date = new DateTime($date);
        $date->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        return $date->format('H:i:s');
    }

    public static function utc_day()
    {
        $date=date('Y-m-d H:i:s');
        $minutes_to_add = 330;
        $date = new DateTime($date);
        $date->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        $date= $date->format('Y-m-d H:i:s');

        return date('N', strtotime($date));
    }

}

class DatabaseFunction{ //only for testing

    public static function last_query()
    {
        $CI =& get_instance();
        var_dump($CI->db->last_query());
        die();
    }
}