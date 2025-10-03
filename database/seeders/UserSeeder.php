<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'uuid' => Str::uuid(),
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_active' => true,
        ]);

        $user->profile()->create([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'birthdate' => '1990-01-01',
            'gender' => 'other',
            'country' => 'Venezuela',
            'phone' => '+58-123456789',
            'bio' => 'Usuario administrador del sistema',
        ]);

        User::factory(10)->create()->each(function ($user) {
            $user->profile()->create(
                UserProfile::factory()->make()->toArray()
            );
        });
    }
}
