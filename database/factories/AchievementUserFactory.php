<?php

namespace Database\Factories;

use App\Models\Achievement;
use App\Models\AchievementUser;
use App\Models\User;
use Database\Seeders\AchievementSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Artisan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AchievementUser>
 */
class AchievementUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AchievementUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        Artisan::call('db:seed', [
            'class' => AchievementSeeder::class
        ]);

        return [
            'user_id' => $user->id,
            'achievement_id' => Achievement::skip(1)->first()->id
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
