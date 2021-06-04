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
    $categories = ['cat one', 'cate two' , 'cat three'];
    foreach($categories as $category) {

        Category::create([
        'ar' => ['name' => $category],
        'en' => ['name' => $category]
        ]);
    }
    }// End of Run
}// End Of Categories Seeder
