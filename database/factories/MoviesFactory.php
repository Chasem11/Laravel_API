<?php

namespace Database\Factories;

use App\Models\Movies;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoviesFactory extends Factory
{
    protected $model = Movies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),   
            'director' => $this->faker->name,        
            'publication_year' => $this->faker->year, 
            'genre' => $this->faker->word,           
            'availability' => $this->faker->boolean,
        ];
    }
}
