<?php

namespace App\Models;

use CodeIgniter\Model;

class UserMeta extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'usermeta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["userId", "dp", "profileHeader", "experience", "education", "profileViews"];
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected $updationDissAllowed = ["userId"];

    public function getMetaId($userId)
    {
        $alreadyExists = $this->select("id")->where("userId", $userId)->first();

        if (is_null($alreadyExists)) {
            $this->save([
                "userId" => $userId,
            ]);
            return $this->getInsertID();
        }

        return $alreadyExists["id"];
    }
    public function getProfileMeta($metaId)
    {
        return $this->find($metaId);
    }

    public function updateFields($userId, $data)
    {
        $metaId = $this->getMetaId($userId);

        try {
            $this->update($metaId, $data);
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
        return true;
    }
    public function addExperience($userId, $expData)
    {
        $metaId = $this->getMetaId($userId);
        $metaData = $this->find($metaId);
        $experience = array();
        if (isset($metaData["experience"])) {
            $experience = json_decode($metaData["experience"], true);
        }
        $expData->id = count($experience) + 1;
        array_push($experience, $expData);

        $this->update($metaId, [
            "experience" => json_encode($experience),
        ]);

        return $experience;
    }
    public function addEducation($userId, $newEntry)
    {
        $metaId = $this->getMetaId($userId);
        $metaData = $this->find($metaId);

        $data = [];
        if (isset($metaData["education"])) {
            $data = json_decode($metaData["education"], true);
        }
        $newEntry->id = count($data) + 1;
        array_push($data, $newEntry);

        $this->update($metaId, [
            "education" => json_encode($data),
        ]);

        return $data;
    }
    public function editExperience($userId, $entityId, $dataToUpdate)
    {
        $metaId = $this->getMetaId($userId);
        $metaData = $this->find($metaId);
        $entries = array();
        if (isset($metaData["experience"])) {
            $entries = json_decode($metaData["experience"], true);
        }
        $cannotUpdate = ["id"];

        $entries = array_map(function ($entityData) use ($entityId, $dataToUpdate, $cannotUpdate) {
            if (strval($entityData['id']) === $entityId) {
                foreach ($dataToUpdate as $field => $value) {
                    if (!in_array($field, $cannotUpdate)) {
                        $entityData[$field] = $value;
                    }
                }
            }
            return $entityData;
        }, $entries);

        $this->update($metaId, [
            "experience" => json_encode($entries),
        ]);

        return $entries;
    }
    public function editEducation($userId, $entityId, $dataToUpdate)
    {
        $metaId = $this->getMetaId($userId);
        $metaData = $this->find($metaId);
        $entries = array();
        if (isset($metaData["education"])) {
            $entries = json_decode($metaData["education"], true);
        }
        $cannotUpdate = ["id"];

        $entries = array_map(function ($entityData) use ($entityId, $dataToUpdate, $cannotUpdate) {
            if (strval($entityData['id']) === $entityId) {
                foreach ($dataToUpdate as $field => $value) {
                    if (!in_array($field, $cannotUpdate)) {
                        $entityData[$field] = $value;
                    }
                }
            }
            return $entityData;
        }, $entries);

        $this->update($metaId, [
            "education" => json_encode($entries),
        ]);

        return $entries;
    }
}
