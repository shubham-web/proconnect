<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CountriesSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        helper("dummy_data");
        $countriesNames = get_countries_list();
        foreach ($countriesNames as $country) {
            array_push($data, [
                "name" => $country,
            ]);
        }
        $this->db->table("countries")->insertBatch($data);
    }
}
