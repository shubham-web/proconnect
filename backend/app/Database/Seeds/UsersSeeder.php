<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        helper(["dummy_data", "password"]);
        // format ["firstName", "lastName", "email", "mobile", "password"]
        $dummyUsers = [
            ["Shubham", "Prajapat", "shubham@indiaskills.com", "8319505750"],
            ["Juned", "Adenwalla", "juned@indiaskills.com"],
            ["Nidhanshu", "Sharma", "nidhanshu@indiaskills.com"],
            ["Shri Hari", "L", "shrihari@indiaskills.com"],
            ["Advaith", "AJ", "aj@indiaskills.com"],
            ["Aliya", "Parveen", "aliya@indiaskills.com"],
            ["Aashish Kumar", "Verma", "aashish@indiaskills.com"],
            ["Pritam", "Das", "pritam@indiaskills.com"],
        ];
        $data = [];
        foreach ($dummyUsers as $user) {
            array_push($data, [
                "firstName" => $user[0],
                "lastName" => $user[1],
                "email" => $user[2],
                "mobile" => $user[3] ?? get_random_mobile_number(),
                "password" => $user[4] ?? strstr($user[2], "@", true) . "_secret", // shubham_secret
                "dob" => get_random_date("01-01-1999", "31-12-2005"),
                "country" => 101 // india 
            ]);
        }

        // hash password
        $data = array_map(function ($user) {
            $user["password"] = pc_password_hash($user["password"]);
            return $user;
        }, $data);

        $this->db->table("users")->insertBatch($data);
    }
}
