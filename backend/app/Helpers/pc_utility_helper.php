<?php

if (!function_exists(("pc_random_token"))) {
    function pc_random_token()
    {
        return str_shuffle(MD5(microtime(true)));
    }
}

if (!function_exists("pc_no_data_message")) {
    function pc_no_data_message()
    {
        return "Fields are missing.";
    }
}

if (!function_exists("pc_filter_keys")) {
    function pc_filter_keys($data, $keysToKeep)
    {
        $filtered = [];
        foreach (array_keys($data) as $feild) {
            if (in_array($feild, $keysToKeep)) {
                $filtered[$feild] = $data[$feild];
            }
        }
        return $filtered;
    }
}

if (!function_exists("pc_confirmed_array")) {
    // converts array/stdClass -> array
    function pc_confirmed_array($input)
    {
        return json_decode(json_encode($input), true);
    }
}
