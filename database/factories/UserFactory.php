<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{

    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomNumber(3, true),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'user_type' => $this->faker->randomElement(['student', 'teacher']),
            'grade_level' => $this->faker->optional()->numberBetween(9, 12),    
            'department' => $this->faker->optional()->word(),                   
            'gender' => $this->faker->randomElement(['male', 'female']),
            'password' => Hash::make('testing123')
        ];
    }
}
