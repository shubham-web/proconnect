<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return $this->response->setJSON([
            "success" => true,
            "message" => "App is running."
        ]);
    }
    public function getCountries()
    {
        $this->countryModel = model(\App\Models\Countries::class);
        return $this->response->setJSON([
            "success" => true,
            "message" => "App is running.",
            "data" => $this->countryModel->findAll(),
        ]);
    }
}
