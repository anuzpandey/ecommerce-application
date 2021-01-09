<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            [
                'name' => 'Brand One',
                'slug' => 'brand-one'
            ],
            [
                'name' => 'Brand Two',
                'slug' => 'brand-two'
            ],
            [
                'name' => 'Brand Three',
                'slug' => 'brand-three'
            ]
        ]);
    }
}
