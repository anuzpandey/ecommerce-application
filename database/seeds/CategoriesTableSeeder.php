<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Root',
            'description' => 'This is the root category, don\'t delete this one',
            'parent_id' => null,
            'menu' => 0,
        ]);

        DB::table('categories')->insert([
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Laptop Section',
                'parent_id' => 1,
                'menu' => 0,
            ],
            [
                'name' => 'Gaming Laptops',
                'slug' => 'gaming-laptops',
                'description' => 'Gaming Laptops',
                'parent_id' => 2,
                'menu' => 0,
            ],
            [
                'name' => 'Macbooks',
                'slug' => 'macbooks',
                'description' => 'Macbooks Laptops',
                'parent_id' => 2,
                'menu' => 0,
            ]
        ]);

//        factory(Category::class, 10)->create();
    }
}
