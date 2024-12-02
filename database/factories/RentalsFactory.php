<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Rentals;
use App\Models\User;
use App\Models\Books;
use App\Models\Movies;

class RentalsFactory extends Factory
{
    protected $model = Rentals::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $isBook = $this->faker->boolean;

        return [
            'renter_id' => User::factory(),
            'rental_date' => $this->faker->date(),
            'return_date' => $this->faker->optional()->date(), 
            'returned' => $this->faker->boolean,
            'book_id' => $isBook ? Books::factory() : null, 
            'movie_id' => !$isBook ? Movies::factory() : null,

        ];
    }
}
