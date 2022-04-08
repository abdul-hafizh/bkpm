<?php


namespace SimpleCMS\Blog\Database\Seeders;


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use SimpleCMS\Blog\Models\CategoryModel;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => 1,
                'parent_id' => NULL,
                'slug' => 'uncategory',
                'name' => 'Uncategory',
                'description' => 'Uncategory',
                'thumb_image' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        CategoryModel::insert($categories);
    }
}