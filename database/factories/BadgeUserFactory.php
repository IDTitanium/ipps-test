<?php

namespace Database\Factories;

use App\Models\Badge;
use App\Models\User;
use Database\Seeders\BadgeSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Artisan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BadgeUser>
 */
class BadgeUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        Artisan::call('db:seed', [
            'class' => BadgeSeeder::class
        ]);

        return [
            'user_id' => $user->id,
            'badge_id' => Badge::first()->id
        ];
    }

    /**
     * Use the same user for all achievements created
     */
    public function withUser(User $user): Factory
    {
        return $this->state(function (array $attributes) use($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
