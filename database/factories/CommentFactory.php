<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => fake()->text(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Use the same user for all comments created
     */
    public function singleUser(): Factory
    {
        $user = User::factory()->create();

        return $this->state(function (array $attributes) use($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
