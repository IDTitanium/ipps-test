<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\AchievementUser;
use App\Models\BadgeUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AchievementControllerTest extends TestCase
{
    /**
     * Can get next achievements from endpoint.
     */
    public function test_can_get_achievement_from_endpoint(): void
    {
        $user = User::factory()->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $body = $response->decodeResponseJson();

        $this->assertNotEmpty($body);
        $this->assertNotEmpty($body['next_available_achievements']);
    }

    /**
     * Can get current achievements from endpoint
     */
    public function test_can_get_current_achievement_from_endpoint(): void
    {
        $user = User::factory()->create();
        AchievementUser::factory(2)->withUser($user)->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $body = $response->decodeResponseJson();

        $this->assertNotEmpty($body);
        $this->assertNotEmpty($body['next_available_achievements']);
        $this->assertNotEmpty($body['unlocked_achievements']);
    }

    /**
     * Can get current badge from endpoint
     */
    public function test_can_get_current_badge_from_endpoint(): void
    {
        $user = User::factory()->create();
        BadgeUser::factory(2)->withUser($user)->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $body = $response->decodeResponseJson();

        $this->assertNotEmpty($body);
        $this->assertNotNull($body['current_badge']);
        $this->assertNotNull($body['next_badge']);
    }
}
