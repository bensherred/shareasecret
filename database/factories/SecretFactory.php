<?php

namespace Database\Factories;

use App\Domain\Secrets\Models\Secret;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Secrets\Models\Secret>
 */
class SecretFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Secret::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => (string) Str::uuid(),
            'value' => encrypt($this->faker->word),
            'ttl' => $this->faker->randomNumber(),
            'email' => $this->faker->boolean ? $this->faker->email : null,
        ];
    }
}
