<?php

namespace Database\Factories;


use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Book::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name,
            'publisher' => $this->faker->company,
            'year' => $this->faker->year,
            'status' => $this->faker->randomElement(['available','borrowed']),
            'category_id' => Category::factory()->create()->id
        ];
    }
}