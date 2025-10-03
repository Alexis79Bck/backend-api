<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\UserProfile;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_profile_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $profile = UserProfile::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $profile->user);
        $this->assertEquals($profile->user->id, $user->id);
    }
}
