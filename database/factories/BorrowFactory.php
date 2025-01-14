<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrow>
 */
class BorrowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Borrow::class;
    public function definition(): array
    {
        return [
            'user_id'=>User::factory()->create(),
            'book_id'=>Book::factory()->create(),
            'borrow_date' => now(),
            'return_date' => now()->addDay(rand(1,10))
        ];
    }
}
