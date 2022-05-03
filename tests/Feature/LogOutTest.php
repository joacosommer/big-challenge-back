<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogOutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_log_out()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->be($user)
            ->post('logout')
            ->assertSuccessful();
        $this->assertGuest();
    }
}
