<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\UserProfile;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_have_a_profile()
    {
        $user = User::factory()->create();

        $profile = UserProfile::factory()->make();
        $user->profile()->create($profile->toArray());

        $this->assertInstanceOf(UserProfile::class, $user->profile);
        $this->assertEquals($user->id, $user->profile->user_id);
    }

    /** @test */
    public function deleting_user_also_deletes_profile()
    {
        $user = User::factory()->create();
        $profile = UserProfile::factory()->create(['user_id' => $user->id]);

        $user->delete();

        $this->assertDatabaseMissing('users_profiles', ['id' => $profile->id]);
    }
}
