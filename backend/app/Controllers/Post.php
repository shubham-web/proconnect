<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Post extends ResourceController
{
    public function __construct()
    {
        $this->postModel = model(\App\Models\PostModel::class);
        $this->userModel = model(\App\Models\Users::class);
    }
    protected $helpers = ["pc_utility"];

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index($offset = 0, $limit = null)
    {
        // $userId = $this->request->getHeaderLine("pc_user");
        $posts = $this->postModel
            ->orderBy("createdAt", "DESC")
            ->offset($offset)
            ->limit($limit)
            ->find(); // not findAll

        $posts = array_map(function ($post) {
            $post["user"] = $this->userModel->select("firstName, lastName")->find($post["userId"]);
            return $post;
        }, $posts);
        return $this->respond([
            "success" => 1,
            "data" => [
                "posts" => $posts,
                "offset" => $offset,
                "limit" => $limit,
                "total" => $this->postModel->countAll(),
            ],
        ], 200);
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
    public function feedPosts($offset = 0, $limit = null)
    {
        $userId =  $this->request->getHeaderLine("pc_user_id");
        $posts = $this->postModel
            ->select("id, userId, text, media, likes, createdAt")
            ->orderBy('createdAt', 'DESC')
            ->offset($offset)
            ->limit($limit)
            ->where("status !=", "SUSPENDED")
            ->find();

        $posts = array_map(function ($post) use ($userId) {
            $post["media"] = json_decode($post["media"], true);
            $post["user"] = $this->userModel->select("firstName, lastName, profileHeader, dp")->find($post["userId"]);
            $post["selfPost"] = $userId === $post["userId"];
            if (isset($post['likes'])) {
                $post["liked"] = in_array($userId, explode(",", $post['likes']));
            }
            return $post;
        }, $posts);
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
        $postId = $id;
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

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->postModel->where("id", $id)->delete();
        return $this->respond([
            "success" => true,
            "message" => "Post Deleted Successfully!",
        ], 200);
    }
    public function likePost($postId = null)
    {
        $userId = $this->request->getHeaderLine("pc_user_id");
        $post = $this->postModel->where("id", $postId)->select("likes")->first();
        if (!$post) {
            return $this->respond([
                "message" => "No such post exists",
            ], 400);
        }
        $exLikes = explode(",", $post["likes"]);
        $alreadyLiked = in_array($userId, $exLikes);
        if ($alreadyLiked) {
            $exLikes = array_filter($exLikes, function ($personUserId) use ($userId) {
                return strval($userId) !== strval($personUserId);
            });
        } else {
            if (count($exLikes) === 1 && $exLikes[0] === "") {
                $exLikes = [$userId];
            } else {
                array_push($exLikes, $userId);
            }
        }

        $exLikes = implode(",", $exLikes);
        $this->postModel->update($postId, [
            "likes" => $exLikes,
        ]);
        return $this->respond([
            "sucess" => true,
            "message" => $alreadyLiked ? "Undone like action" : "Liked the post",
            "data" => [
                "likes" => $exLikes,
            ]
        ], 200);
    }
}
