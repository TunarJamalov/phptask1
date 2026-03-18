<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserBanTest extends TestCase
{
    use RefreshDatabase;

    public function test_deactivated_user_cannot_login()
    {
        $user = User::factory()->create([
            'email' => 'hacker@test.com',
            'password' => bcrypt('password123'),
            'is_active' => false,
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'hacker@test.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();

        $response->assertInvalid(['email']);
    }
    //
}
