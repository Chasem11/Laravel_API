<?php

namespace Database\Factories;
use App\Models\Books;
use Illuminate\Database\Eloquent\Factories\Factory;

class BooksFactory extends Factory
{
    protected $model = Books::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3), 
            'author' => $this->faker->name,       
            'publication_year' => $this->faker->year, 
            'genre' => $this->faker->word,      
            'availability' => $this->faker->boolean, 
        ];
    }
}
