<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            "message" => "No such api endpoint found."
        ]);
    }
}
