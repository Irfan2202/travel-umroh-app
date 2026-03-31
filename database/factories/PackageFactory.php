<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Package>
 */

class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Daftar nama paket yang realistis
        $packageName = $this->faker->randomElement([
            'Umroh Reguler Syawal',
            'Umroh Plus Turki & Cappadocia',
            'Ibadah I\'tikaf Ramadhan',
            'Umroh Milad Spesial',
            'Paket Umroh Akhir Tahun',
            'Umroh Arbain Madinah'
        ]);

        // Tentukan harga dasar (Quad) antara 26jt - 35jt
        $basePrice = $this->faker->numberBetween(26, 35) * 1000000;

        return [
            'name' => $packageName,
            // Slug unik agar tidak error saat seeder dijalankan masif
            'slug' => Str::slug($packageName . '-' . $this->faker->unique()->numberBetween(100, 999)),

            'departure_date' => $this->faker->dateTimeBetween('+2 months', '+8 months'),
            'return_date' => $this->faker->dateTimeBetween('+9 months', '+10 months'),

            // Harga berjenjang (Quad < Triple < Double)
            'price_quad' => $basePrice,
            'price_triple' => $basePrice + 1500000,
            'price_double' => $basePrice + 3000000,

            'quota' => 45,
            'available_seats' => $this->faker->numberBetween(0, 45),

            'airline' => $this->faker->randomElement(['Garuda Indonesia', 'Saudi Arabian Airlines', 'Lion Air', 'Batik Air']),
            'hotel_makkah' => $this->faker->randomElement(['Pullman Zamzam', 'Swissotel Al Maqam', 'Anjum Hotel', 'Olayan Ajyad']),
            'hotel_madinah' => $this->faker->randomElement(['Anwar Al Madinah', 'Dyar Al Madinah', 'Ruve Al Madinah']),

            'status' => $this->faker->randomElement(['draft', 'published', 'closed']),
        ];
    }
}
