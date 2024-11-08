<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class DefaultCategorySeeder extends Seeder
{
    public function run()
    {
        Category::firstOrCreate(['name' => 'Uncategorized', 'slug' => 'uncategorized']);
    }
}
