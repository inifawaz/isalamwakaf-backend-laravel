<?php

namespace Database\Seeders;

use App\Models\CampaignCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CampaignCategory::create([
            "name" => 'Pembangunan',
            'slug' => 'pembangunan'
        ]);
        CampaignCategory::create([
            "name" => 'Pendidikan',
            'slug' => 'pendidikan'
        ]);
        CampaignCategory::create([
            "name" => 'Sosial',
            'slug' => 'Sosial'
        ]);
    }
}
