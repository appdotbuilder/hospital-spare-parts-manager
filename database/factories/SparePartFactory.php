<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SparePart>
 */
class SparePartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(0, 100);
        $minimumStock = fake()->numberBetween(1, 20);
        
        return [
            'name' => fake()->words(3, true),
            'code' => fake()->unique()->regexify('[A-Z]{2,3}-[0-9]{3,4}'),
            'quantity' => $quantity,
            'storage_location' => fake()->regexify('[A-Z][0-9]{1,2}-[A-Z][0-9]{1,2}'),
            'price' => fake()->randomFloat(2, 10, 1000),
            'minimum_stock' => $minimumStock,
            'supplier_id' => Supplier::factory(),
            'description' => fake()->sentence(),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Indicate that the spare part is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the spare part has low stock.
     */
    public function lowStock(): static
    {
        return $this->state(function (array $attributes) {
            $minimumStock = fake()->numberBetween(5, 15);
            return [
                'quantity' => fake()->numberBetween(0, $minimumStock - 1),
                'minimum_stock' => $minimumStock,
            ];
        });
    }
}