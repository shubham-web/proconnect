<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Exception;

class Auth extends ResourceController
{
    public function __construct()
    {
        $this->model = model(\App\Models\Users::class);
        $this->accessTokensModel = model(\App\Models\AccessTokensModel::class);
    }
    protected $helpers = ["dummy_data", "password", "pc_utility"];
    public function index()
    {
        return $this->respond([
            "message" => "You're at the wrong place!",
        ]);
    }
    public function login()
    {
        // run basic validations such as required
        $rules      = $this->basicLoginValidationRules();
        $goodToGo   = $this->validate($rules);

        if (!$goodToGo) {
            return $this->respond([
                "message"   => "There are some validation errors",
                "errors"    => $this->validator->getErrors(),
            ], 400);
        }

        $emailOrMobile      = $this->request->getVar("emailOrMobile");
        $password           = $this->request->getVar("password");
        $usingMobileNumber  = $this->validator->check($emailOrMobile, 'decimal');
        $usingEmail         = !$usingMobileNumber;

        // if user is using email to login then validate email
        if ($usingEmail) {
            $validEmail = $this->validator->check($emailOrMobile, "valid_email");
            if (!$validEmail) {
                return $this->respond([
                    "message"   => "Invalid email address provided.",
                    // "errors" => $this->validator->getErrors(),
                ], 400);
            }
        }

        $loginChecks = $this->model->canLogin($emailOrMobile, $usingEmail);

        if (isset($loginChecks["error"])) {
            return $this->respond([
                "message" => $loginChecks["error"],
            ], 400);
        }
        $targetUser = $loginChecks["user"];

        // check password
        if (!pc_match_password($password, $targetUser["password"])) {
            // incorrect password
            $field = $usingEmail ? "email" : "mobile number";
            return $this->respond([
                "message" => "Invalid " . $field . " or password entered.",
            ], 403);
        }

        // all checks done
        // -> create a token

        $token = pc_random_token();
        try {
            $this->accessTokensModel->saveUserAuthToken([
                // "type" => "USER_AUTH",
                "token" => $token,
                "targetUser" => $targetUser["id"],
                "ip" => $this->request->getIPAddress(),
            ]);
        } catch (Exception $e) {
            return $this->respond([
                "message" => "An error occurred while logging in, please try again later.",
                "error" => $e->getMessage(),
            ], 500);
        }


        return $this->respond([
            "success" => 1,
            "message" => "Logged in successfully!",
            "data" => [
                "token" => $token,
                "targetUser" => pc_filter_keys($targetUser, ["firstName", "lastName", "role"])
            ]
        ], 200);
    }
    public function register()
    {
        // validate data
        $rules = self::getRegistrationRules();
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

        $rowData["password"] = pc_password_hash($rowData["password"]);

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

    protected function basicLoginValidationRules()
    {
        return [
            "emailOrMobile" => [
                "label" => "Email or Mobile number",
                "rules" => "required"
            ],
            "password" => [
                "label" => "Password",
                "rules" => "required|string"
            ]
        ];
    }

    static function getRegistrationRules($returnOnly = [])
    {
        $requiredString = "required|string";
        $allRules = [
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
                "rules" => "required|valid_date[d-m-Y]",
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
        if (count($returnOnly) === 0) {
            return $allRules;
        }
        $filteredRules = [];
        foreach ($returnOnly as $field) {
            $filteredRules[$field] = $allRules[$field];
        }
        return $filteredRules;
    }
    public function noRoute()
    {
        return $this->respond([
            "message" => "No such api endpoint found."
        ]);
    }
}
