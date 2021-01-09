<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             AdminsTableSeeder::class,
             SettingsTableSeeder::class,
             CategoriesTableSeeder::class,
             BrandsTableSeeder::class,
             AttributesTableSeeder::class,
             AttributeValuesTableSeeder::class,
         ]);
    }
}
