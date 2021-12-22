<?php

if (!function_exists("pc_password_hash")) {
    function pc_password_hash($password = "")
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
if (!function_exists("pc_match_password")) {
    function pc_match_password($password = "", $hash = "")
    {
        return password_verify($password, $hash);
    }
}
