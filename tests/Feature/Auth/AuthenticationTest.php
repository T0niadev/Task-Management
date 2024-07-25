<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;


class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_login()
    {
        // Ensure the user exists
        $user = \App\Models\User::factory()->create([
            'email' => 'testt@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/api/login', [
            'email' => 'testt@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);

        // Store token for subsequent requests
        $this->token = $response->json('token');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_logout()
    {
        $this->test_login(); // Ensure the user is logged in and has a token
    
        $response = $this->post('/api/logout', [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);
    
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Logged out successfully.']);
    }
}
