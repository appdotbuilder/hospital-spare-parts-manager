<?php

namespace Database\Factories;

use App\Models\SparePart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UsageRecord>
 */
class UsageRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'approved', 'rejected']);
        
        return [
            'spare_part_id' => SparePart::factory(),
            'user_id' => User::factory(),
            'quantity_used' => fake()->numberBetween(1, 10),
            'purpose' => fake()->sentence(),
            'notes' => fake()->optional()->paragraph(),
            'usage_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => $status,
            'approved_by' => $status !== 'pending' ? User::factory() : null,
            'approved_at' => $status !== 'pending' ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }

    /**
     * Indicate that the usage record is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
        ]);
    }

    /**
     * Indicate that the usage record is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'approved_by' => User::factory(),
            'approved_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}