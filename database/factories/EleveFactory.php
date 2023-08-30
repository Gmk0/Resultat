<?php

namespace Database\Factories;

use App\Models\Classe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eleve>
 */
class EleveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return
            [
                'nom' => $this->faker->lastName(),
                'postnom' => $this->faker->firstName(),
                'prenom' => $this->faker->firstName(),
                'date_naissance' => $this->faker->date(),
                'lieu_naissance' => $this->faker->city(),
                'sexe' => $this->faker->randomElement(['M', 'F']),
                'addresse' => $this->faker->address(),
                'classe_id' => Classe::inRandomOrder()->first()->id,
            ];
    }
}