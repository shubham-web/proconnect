<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // return $this->getErrorResponse();
        return $this->getSuccessResponse();
    }

    private function getErrorResponse()
    {
        return $this->response->setStatusCode(500)->setJSON([
            "message" => "Internal server error",
        ]);
    }
    private function getSuccessResponse()
    {
        return $this->response->setJSON([
            "success" => true,
            "message" => "App is running."
        ]);
    }
}
