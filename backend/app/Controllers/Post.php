<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Post extends ResourceController
{
    public function __construct()
    {
        $this->postModel = model(\App\Models\PostModel::class);
    }
    protected $helpers = ["pc_utility"];

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return $this->respond([
            "success" => true,
            "data" => $this->postModel->findAll(),
        ]);
    }
    public function export($format = "csv")
    {
        $colsToExport = ["id", "userId", "text", "media", "likes"];
        $posts = $this->postModel->findAll();
        $csvFileContent = "";

        for ($i = 0; $i < count($posts); $i++) {
            $post = $posts[$i];
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
                $columnValue = $post[$columnName];
                $csvFileContent .= $columnValue;
                if ($j === count($colsToExport) - 1) {
                    // last col -> add new line
                    $csvFileContent .= "\n";
                } else {
                    $csvFileContent .= ", ";
                }
            }
        }

        return $this->response->download("posts.csv", $csvFileContent);
    }
    public function changePostStatus()
    {
        $postId = $this->request->getJsonVar("id");
        $newStatus = $this->request->getJsonVar("status");
        try {
            $this->postModel->update($postId, [
                "status" => $newStatus,
            ]);
        } catch (\Exception $e) {
            return $this->respond([
                "message" => $e->getMessage(),
            ], 500);
        }

        return $this->respond([
            "message" => "Post updated successfully.",
        ]);
    }
    public function feedPosts($offset = 0, $limit = null)
    {
        $posts = $this->postModel
            ->offset($offset)
            ->limit($limit)
            ->select("id, userId, text, media, likes")
            ->where("status !=", "SUSPENDED")
            ->find();
        return $this->respond([
            "success" => true,
            "data" => $posts
        ], 200);
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
        $userId = $this->request->getHeaderLine("pc_user_id");
        if (!$this->request->getJSON()) {
            return $this->respond([
                "message" => pc_no_data_message(),
            ], 400);
        }
        if (is_null($this->request->getJsonVar("text")) && is_null($this->request->getJsonVar("media"))) {
            return $this->respond([
                "message" => "Either text or media is required to create a post."
            ], 400);
        }

        try {
            $this->postModel->save([
                "userId" => $userId,
                "text" => $this->request->getJsonVar("text"),
                "media" => json_encode($this->request->getJsonVar("media")),
            ]);
            return $this->respond([
                "message" => "Post created successfully.",
                "data" => [
                    "id" => $this->postModel->getInsertID()
                ]
            ]);
        } catch (\Exception $e) {
            return $this->respond([
                "message" => $e->getMessage(),
            ], 500);
        }
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
