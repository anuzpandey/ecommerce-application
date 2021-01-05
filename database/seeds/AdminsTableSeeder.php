<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AdminsTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        Admin::create([
            'name' => 'Anuj Pandey',
            'email' => 'admin@admin.com',
            'password' => bcrypt('secret')
        ]);
    }
}
