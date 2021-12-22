<?php

if (!function_exists("get_countries_list")) {
    function get_countries_list()
    {
        $countries = file_get_contents(APPPATH . "Helpers/data/countries.json");
        $countries = json_decode($countries, true);
        $countries = array_map(function ($country) {
            return $country["name"];
        }, $countries);
        return $countries;
    }
}

if (!function_exists("get_random_mobile_number")) {
    function get_random_mobile_number()
    {
        return rand(1111111111, 9999999999);
    }
}

if (!function_exists("get_random_date")) {
    function get_random_date($startDate, $endDate)
    {
        $min = strtotime($startDate);
        $max = strtotime($endDate);

        $_random = rand($min, $max);
        return date("Y-m-d", $_random);
    }
}
