<?php

namespace Database\Factories;

use App\Models\Bahan;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ListMenu>
 */
class ListMenuFactory extends Factory
{
    public function fillMenu($menu)
    {
        return $this->state(function (array $attributes) use ($menu) {
            return [
                'menu_id' => $menu->id,
            ];
        });
    }

    public function definition(): array
    {
        $bahan = Bahan::inRandomOrder()->first();

        return [
            'menu_id' => Menu::inRandomOrder()->first()?->id, // default kalau ga diisi
            'bahan_id' => $bahan?->id,
            'jumlah' => fake()->numberBetween(10, 100),
        ];
    }
}
