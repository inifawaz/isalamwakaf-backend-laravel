<?php

namespace Database\Factories;

use App\Models\CampaignCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence(15);
        return [
            "featured_image_url" => "wakaf.jpg",
            "title" => $title,
            "slug" => Str::slug($title),
            "category_id" => fake()->randomElement(CampaignCategory::get()->pluck('id')),
            "content" => fake()->sentence(250),
            'maintenance_fee' => 1000,
            'is_target' => fake()->randomElement([false, false, false, true]),
            "target_amount" => fake()->randomElement([5000000, 15000000, 23000000, 40000000, 3000000, 8000000]),
            "choice_amount" => [20000, 50000, 100000, 200000],
            "is_limited_time" => fake()->randomElement([false, false, false, true]),
            "start_date" => '2023-01-17',
            "end_date" => '2023-02-17',
            "is_hidden" => fake()->randomElement([false, false, false, true]),
            "is_selected" => fake()->randomElement([false, false, false, true]),
            "is_completed" => fake()->randomElement([false, false, false, true]),
            "creator_id" => fake()->randomElement(User::role('admin')->pluck('id'))
        ];
    }
}
