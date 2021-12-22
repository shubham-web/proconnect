<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

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
    }
    public function index($offset = 0, $limit = null)
    {
        echo $this->request->getHeader("userId");
        $users = $this->userModel
            ->offset($offset)
            ->limit($limit)
            ->select("id, firstName, lastName, country, email, status, createdAt")
            ->find(); // not findAll
        return $this->respond([
            "success" => 1,
            "data" => [
                "total" => $this->userModel->countAll(),
                "users" => $users,
                "offset" => $offset,
                "limit" => $limit,
            ],
        ], 200);
    }

    public function me()
    {
        // return 
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
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
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
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
