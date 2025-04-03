<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pessoa>
 */
class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pes_nome' => $this->faker->name,
            'pes_data_nascimento' => $this->faker->date,
            'pes_sexo' => $this->faker->randomElement(['M', 'F']),
            'pes_mae' => $this->faker->name,
            'pes_pai' => $this->faker->name,
        ];
    }
}
