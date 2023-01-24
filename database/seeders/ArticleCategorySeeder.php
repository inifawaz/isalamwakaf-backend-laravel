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
            "name" => 'Pendidikan',
            'slug' => 'pendidikan'
        ]);
        ArticleCategory::create([
            "name" => 'Ekonomi Syariah',
            'slug' => 'ekonomi-syariah'
        ]);
        ArticleCategory::create([
            "name" => 'Muamalah',
            'slug' => 'muamalah'
        ]);
        ArticleCategory::create([
            "name" => 'Fiqih',
            'slug' => 'fiqih'
        ]);
        ArticleCategory::create([
            "name" => 'Berita',
            'slug' => 'berita'
        ]);
        ArticleCategory::create([
            "name" => 'Tutorial',
            'slug' => 'tutorial'
        ]);
    }
}
