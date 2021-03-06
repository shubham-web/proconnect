<?php

namespace App\Models;

use CodeIgniter\Model;

class AccessTokensModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'accesstokens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["token", "targetUser", "ip", "lastUsedAt"];

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

    public function saveUserAuthToken($data)
    {

        // delete old tokens genereated for this ip
        $userId = $data["targetUser"];
        $this->where(["targetUser" => $userId, "ip" => $data["ip"]])->delete();

        $this->save([
            "token" => $data["token"],
            "targetUser" => $userId,
            "ip" => $data["ip"],
        ]);
    }
    public function getUserIdFromToken($token)
    {
        $accessTokenEntry = $this->where(["token" => $token])->first();
        if (is_null($accessTokenEntry)) {
            return ["error" => "Invalid token provided."];
        }
        return [
            "userId" => $accessTokenEntry["targetUser"]
        ];
    }
}
