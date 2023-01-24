<?php

namespace Database\Factories;

use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
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
            "featured_image_url" => "article.jpg",
            "title" => $title,
            "slug" => Str::slug($title),
            "category_id" => fake()->randomElement(ArticleCategory::get()->pluck('id')),
            "content" => fake()->sentence(250),
            "is_hidden" => fake()->randomElement([false, false, false, true]),
            "is_selected" => fake()->randomElement([false, false, false, true]),
            "creator_id" => fake()->randomElement(User::role('admin')->pluck('id'))
        ];
    }
}
