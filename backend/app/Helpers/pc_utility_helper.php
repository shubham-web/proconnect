<?php

if (!function_exists(("pc_random_token"))) {
    function pc_random_token()
    {
        return str_shuffle(MD5(microtime(true)));
    }
}
