<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Entregador;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entregador>
 */
class EntregadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'telefone' => $this->faker->phoneNumber(),
            'tipoVeiculo' => $this->faker->randomElement([1,2,3,4]),
        ];
    }
}
