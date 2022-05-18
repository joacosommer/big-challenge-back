<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LogInTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_log_in()
    {
        $this->withDeprecationHandling();
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertSuccessful();
        $this->assertAuthenticatedAs($user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_cannot_log_in_with_invalid_credentials()
    {
        $this->withDeprecationHandling();
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password11asdad',
        ]);
        $response->assertJson([
            'error' => 'Invalid credentials',
        ]);
        $this->assertGuest();
    }

    public function test_user_cannot_log_in_with_invalid_email()
    {
        $this->withDeprecationHandling();
        User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $response = $this->post('/login', [
            'email' => 'invalid-email@gmail.com',
            'password' => 'password',
        ]);
        $response->assertJson([
            'error' => 'Invalid credentials',
        ]);
        $this->assertGuest();
    }

    public function test_user_cannot_log_in_if_already_logged_in()
    {
        $this->withDeprecationHandling();
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $this->actingAs($user);
        $user2 = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $response = $this->post('/login', [
            'email' => $user2->email,
            'password' => 'password',
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }
}
