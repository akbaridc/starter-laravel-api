<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Posts;
use Illuminate\Support\Str;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //buatkan seeder 50 data untuk table posts dengan faker dan field berikut title, slug, image, excerpt, description
        Posts::factory()->count(50)->create();
    }
}
