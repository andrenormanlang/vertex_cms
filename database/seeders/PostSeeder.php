<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Post::create([
            'title' => 'Welcome to Vertex CMS',
            'slug' => 'welcome-to-vertex-cms',
            'body' => 'This is your first post in Vertex CMS!'
        ]);

        // Add more sample posts as needed
    }
}
