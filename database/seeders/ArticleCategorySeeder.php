<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleCategory::create([
            "name" => 'Berita',
            'slug' => 'berita'
        ]);
        ArticleCategory::create([
            "name" => 'Panduan',
            'slug' => 'tutorial'
        ]);
    }
}
