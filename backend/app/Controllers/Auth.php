<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Exception;

class Auth extends ResourceController
{
    public function __construct()
    {
        $this->model = model(\App\Models\Users::class);
    }
    // protected $helpers = ["form", "url"];
    public function index()
    {
        return $this->respond([
            "message" => "You're at the wrong place!",
            // "data" => $this->model->findAll(),
        ]);
    }
    public function login()
    {
        return $this->respond([
            "message" => "coming soon",
        ]);
    }
    public function register()
    {
        // validate data
        $rules = $this->getRegistrationRules();
        $goodToGo = $this->validate($rules);

        if (!$goodToGo) {
            return $this->respond([
                "message" => "There are some validation errors",
                "errors" => $this->validator->getErrors(),
            ], 400);
        }


        $alreadyExists = $this->userExists($this->request->getVar("email"));
        if ($alreadyExists) {
            return $this->respond([
                "message" => "User with the email " . $this->request->getVar("email") . " already exists.",
            ], 409);
        }

        // add data to rowData
        $columnsToSave = ["firstName", "lastName", "country", "email", "mobile", "dob", "password"];
        $rowData = [];
        foreach ($columnsToSave as $column) {
            $rowData[$column] = $this->request->getVar($column);
        }
        $rowData["dob"] = strtotime($rowData["dob"]);
        $rowData["dob"] = date("Y-m-d", $rowData["dob"]);

        $rowData["password"] = $this->hashPassword($rowData["password"]);

        // finally save it to db
        try {
            $this->model->save($rowData);
            return $this->respondCreated([
                "success" => true,
                "message" => "Account Created Successfully."
            ]);
        } catch (Exception $e) {
            $error = $e->getMessage();
            return $this->respond([
                "message" => $error
            ]);
        }
    }

    protected function userExists($email)
    {
        $targetUser = $this->model->where(["email" => $email])->first(); // returns NULL if not exists
        return is_null($targetUser) === NULL ? false : $targetUser;
    }

    protected function getRegistrationRules()
    {
        $requiredString = "required|string";
        return [
            "firstName" => [
                "label" => "First Name",
                'rules' => $requiredString,
            ],
            "lastName" => [
                "label" => "Last Name",
                'rules' => $requiredString,
            ],
            "country" => [
                "label" => "Country",
                'rules' => "required|decimal|greater_than[0]|less_than[300]",
                "errors" => [
                    "greater_than" => "Invalid country selected.",
                    "less_than" => "Invalid country selected.",
                ]
            ],
            "email" => [
                "label" => "Email",
                "rules" => "required|valid_email"
            ],
            "mobile" => [
                "label" => "Mobile Number",
                "rules" => "required|numeric"
            ],
            "dob" => [
                "label" => "Date of Birth",
                "rules" => "required|valid_date[d/m/Y]",
            ],
            "password" => [
                "label" => "Password",
                "rules" => "required|min_length[10]",
                "errors" => [
                    "min_length" => "The {field} should at least be of 10 characters."
                ]
            ],
            "passwordconf" => [
                "label" => "Confirm Password",
                "rules" => "required|matches[password]",
            ]
        ];
    }
    protected function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    protected function matchPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
