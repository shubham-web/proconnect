<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

use App\Controllers\Auth;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function __construct()
    {
        $this->userModel = model(\App\Models\Users::class);
        $this->userMeta = model(\App\Models\UserMeta::class);
        $this->validator = service("validation");
    }
    protected $helpers = ["form", "pc_utility"];
    public function index($offset = 0, $limit = null)
    {
        // $userId = $this->request->getHeaderLine("pc_user");
        $users = $this->userModel
            ->offset($offset)
            ->limit($limit)
            ->select("id, firstName, lastName, country, email, status, createdAt")
            ->find(); // not findAll
        return $this->respond([
            "success" => 1,
            "data" => [
                "users" => $users,
                "offset" => $offset,
                "limit" => $limit,
                "total" => $this->userModel->countAll(),
            ],
        ], 200);
    }

    public function me()
    {
        $userId = $this->request->getHeaderLine("pc_user_id");
        $user = $this->userModel->select("firstName, lastName, role, dp")->find($userId);

        return $this->respond([
            "success" => true,
            "data" => $user
        ], 200);
    }
    public function getProfileData()
    {
        $userId = $this->request->getHeaderLine("pc_user_id");
        $user = $this->userModel
            ->select("id, firstName, lastName, email, mobile, dob, profileHeader, dp")
            ->find($userId);
        /* if (isset($user["dob"])) {
            $user["dob"] = date("d-m-Y", strtotime($user["dob"]));
        } */

        $user["metadata"] = $this->userMeta->select("experience, education, profileViews")->where("userId", $userId)->first();

        return $this->respond([
            "success" => true,
            "data" => $user
        ], 200);
    }
    public function updateProfile()
    {
        $userId = $this->request->getHeaderLine("pc_user_id");

        $allowedFields = $this->userModel->allowedFields;

        $allowedFields = array_filter($allowedFields, function ($feild) {
            if (in_array($feild, ["email", "mobile", "password"])) {
                return false;
            }
            return true;
        });

        $dataToUpdate = [];
        if (!$this->request->getJSON()) {
            return $this->respond([
                "message" => "No data provided for updation.",
            ], 400);
        }

        foreach ($this->request->getJSON() as $feild => $newValue) {
            if (!in_array($feild, $allowedFields)) {
                continue;
            }
            $dataToUpdate[$feild] = $newValue;
        }
        /* if (isset($dataToUpdate["dob"])) {
            $dataToUpdate["dob"] = date("d-m-Y", strtotime($dataToUpdate["dob"]));
        } */

        if (count(array_keys($dataToUpdate)) === 0) {
            return $this->respond([
                "message" => "Nothing to update, if any feilds were passed consider them as now allowed.",
            ], 400);
        }

        $fieldToUpdate = array_keys($dataToUpdate);
        $validationRules = Auth::getRegistrationRules($fieldToUpdate);

        $this->validator->setRules($validationRules);
        $goodToGo = $this->validator->run($dataToUpdate);
        if (!$dataToUpdate["dp"]) {
            if (!$goodToGo) {
                return $this->respond([
                    "message" => "Validation errors occurred.",
                    "errors" => $this->validator->getErrors(),
                ], 400);
            }
        }


        $this->userModel->update($userId, $dataToUpdate);

        return $this->respond([
            "success" => true,
            "message" => "Profile updated successfully!",
            "data" => $dataToUpdate,
        ], 200);
    }
    public function updateUserMeta()
    {
        $userId = $this->request->getHeaderLine("pc_user_id");

        $dataToUpdate = $this->request->getJSON();

        if (!$dataToUpdate) {
            return $this->respond([
                "message" => "No data is provided."
            ], 400);
        }

        $updated = $this->userMeta->updateFields($userId, $dataToUpdate);
        if ($updated["error"]) {
            return $this->respond([
                "error" => $updated["error"],
            ], 400);
        }

        return $this->respond([
            "message" => "User meta updated successfully."
        ], 200);
    }
    public function addExperience()
    {
        if (!$this->request->getJSON()) {
            return $this->respond([
                "message" => "Fields are missing.",
            ], 400);
        }
        $userId = $this->request->getHeaderLine("pc_user_id");
        $experience = $this->userMeta->addExperience($userId, $this->request->getJSON());
        return $this->respond([
            "success" => true,
            "message" => "Experience added successfully.",
            "data" => [
                "experience" => $experience

            ]
        ]);
    }
    public function addEducation()
    {
        if (!$this->request->getJSON()) {
            return $this->respond([
                "message" => "Fields are missing.",
            ], 400);
        }
        $userId = $this->request->getHeaderLine("pc_user_id");
        $education = $this->userMeta->addEducation($userId, $this->request->getJSON());
        return $this->respond([
            "success" => true,
            "message" => "Education added successfully.",
            "data" => [
                "education" => $education
            ]
        ]);
    }
    public function export($format = "csv")
    {
        $colsToExport = ["id", "firstName", "lastName", "country", "email", "mobile", "password", "status", "role", "dob", "createdAt", "updatedAt"];
        $users = $this->userModel->findAll();
        $csvFileContent = "";

        for ($i = 0; $i < count($users); $i++) {
            $user = $users[$i];
            // add columsn in first row
            if ($i === 0) {
                for ($j = 0; $j < count($colsToExport); $j++) {
                    $columnName = $colsToExport[$j];
                    $csvFileContent .= $columnName;
                    if ($j === count($colsToExport) - 1) {
                        // last col -> add new line
                        $csvFileContent .= "\n";
                    } else {
                        $csvFileContent .= ", ";
                    }
                }
            }
            for ($j = 0; $j < count($colsToExport); $j++) {
                $columnName = $colsToExport[$j];
                $columnValue = $user[$columnName];
                $csvFileContent .= $columnValue;
                if ($j === count($colsToExport) - 1) {
                    // last col -> add new line
                    $csvFileContent .= "\n";
                } else {
                    $csvFileContent .= ",";
                }
            }
        }

        return $this->response->download("users.csv", $csvFileContent);
    }
    public function import()
    {
        $csvData = $this->request->getVar("csv");

        $csvToArray = (array) array_map("str_getcsv", explode("\n", $csvData));

        $keys = array_map(function ($key) {
            return trim($key);
        }, $csvToArray[0]);
        array_shift($csvToArray);
        $usersWithoutKeys = $csvToArray;
        $usersWithoutKeys = array_filter($usersWithoutKeys, function ($userData) {
            return !is_null($userData[0]) && count($userData) !== 1;
        });
        $users = [];
        foreach ($usersWithoutKeys as $value) {
            $user = [];
            $keyIndex = 0;
            foreach ($keys as $key) {
                $user[$key] = $value[$keyIndex];
                $keyIndex++;
            }
            array_push($users, $user);
        }

        try {
            $this->userModel->insertBatch($users);
        } catch (\Exception $e) {
            return $this->respond([
                "message" => $e->getMessage(),
            ], 500);
        }

        return $this->respond([
            "success" => true,
            "message" => "Users Imported Succesffully!",
        ], 200);
    }
    public function upload()
    {
        $userId = $this->request->getHeaderLine("pc_user_id");
        $subDir = $this->request->getVar("dir");
        $files = $this->request->getFileMultiple("file");
        if ($subDir) {
            if (substr($subDir, -1) !== "/") {
                $subDir .= "/";
            }
        }

        $response = [];
        foreach ($files as $file) {
            $originalName = $file->getName();
            $name = $file->getRandomName();
            $uploadPath =  "usercontent/" . $userId . "/" . $subDir;
            $file->move(FCPATH . $uploadPath, $name);
            array_push($response, [
                "name" => $originalName,
                "path" => $uploadPath . $name,
            ]);
        }

        return $this->respond([
            "success" => true,
            "message" => "File(s) uploaded successfully!",
            "data" => $response,
        ], 200);
    }

    public function editExperience($id = null)
    {
        $userId = $this->request->getHeaderLine('pc_user_id');
        if (!$this->request->getJSON()) {
            return $this->respond([
                "message" => pc_no_data_message(),
            ], 400);
        }
        $experience = $this->userMeta->editExperience($userId, $id, $this->request->getJSON(true));
        return $this->respond([
            "success" => true,
            "message" => "Changes Saved!",
            "data" => [
                "experience" => $experience,
            ]
        ]);
    }
    public function editEducation($id = null)
    {
        $userId = $this->request->getHeaderLine('pc_user_id');
        if (!$this->request->getJSON()) {
            return $this->respond([
                "message" => pc_no_data_message(),
            ], 400);
        }
        $education = $this->userMeta->editEducation($userId, $id, $this->request->getJSON(true));
        return $this->respond([
            "success" => true,
            "message" => "Changes Saved!",
            "data" => [
                "education" => $education,
            ]
        ]);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $targetUser = $id;
        if (!$this->request->getJSON()) {
            return $this->respond([
                "messge" => pc_no_data_message()
            ], 400);
        }

        try {
            $this->userModel->update($targetUser, $this->request->getJSON(true));
        } catch (\Exception $e) {
            return $this->respond([
                "message" => $e->getMessage(),
            ], 500);
        }

        return $this->respond([
            "success" => true,
            'message' => "Changes Saved Successfully!",
            "data" => pc_filter_keys($this->userModel->find($targetUser), ["id", "firstName", "lastName", "country", "email", "mobile", "status", "dob", "role", "createdAt"])
        ], 200);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $targetUser = $id;

        try {
            $deleted = $this->userModel->where("id", $targetUser)->delete();
        } catch (\Exception $e) {
            return $this->respond([
                "message" => $e->getMessage(),
            ], 500);
        }

        return $this->respond([
            "success" => true,
            'message' => "User Deleted Sucessfully!",
        ], 200);
    }
    public function connections()
    {
        $userId = $this->request->getHeaderLine("pc_user_id");
        $users = $this->userModel->select("firstName, lastName")->where("id !=", $userId)->limit(5)->find();
        return $this->respond([
            "success" => true,
            "data" => $users
        ], 200);
    }
}
