<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    public $allowedFields    = ["firstName", "lastName", "country", "email", "mobile", "status", "dob", "password", "profileHeader", "dp"];

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

    // custom
    public const VERIFIED = "VERIFIED";
    public const UNVERIFIED = "UNVERIFIED";
    public const SUSPENDED = "SUSPENDED";

    public function canLogin($emailOrMobile, $usingEmail)
    {
        $fieldName = $usingEmail ? "email" : "mobile";
        $fieldValue = $emailOrMobile;

        $potentialUser = $this->where($fieldName, $fieldValue)->first(); // returns null if not found
        return $this->getActiveUser($potentialUser["id"]);
    }
    public function getActiveUser($userId)
    {
        if (!$userId) {
            return ["error" => "No Such User Exists."];
        }

        $user = $this->find($userId);

        // check if it exists
        if (is_null($user)) {
            return ["error" => "No Such User Exists."];
        }

        // check if user is verified
        if ($user["status"] !== self::VERIFIED) {
            return ["error" => "This account is " . strtolower($user["status"]) . "."];
        }

        return [
            "user" => $user
        ];
    }
}
