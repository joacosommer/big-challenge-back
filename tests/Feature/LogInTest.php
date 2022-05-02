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
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertSuccessful();
//        $response->assertJson(['user' => $user->id]);
    }
}
