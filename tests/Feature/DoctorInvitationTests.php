<?php

namespace Tests\Feature;

use App\Models\DoctorInvitation;
use App\Models\User;
use App\Notifications\DoctorInvitationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DoctorInvitationTests extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_doctor_can_be_invited_to_join_the_system()
    {
        Notification::fake();
        $this->withoutExceptionHandling();
        Role::create(['name' => 'admin']);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);
        $response = $this->post('api/doctor/invite', [
            'email' => 'doctor@gmail.com',
            ]);
        $response->assertSuccessful();
        $this->assertDatabaseHas('doctor_invitations', [
            'email' => 'doctor@gmail.com',
        ]);
//        $doctorInvitation = DoctorInvitation::first();
//        Notification::assertSentTo($doctorInvitation, DoctorInvitationNotification::class);
    }

    /** @test */
    public function test_only_admins_can_invite_doctors()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('api/doctor/invite', [
            'email' => 'doctor@gmail.com',
        ]);
        $response->assertSee([
            'message' => 'User does not have the right roles.',
        ]);
        $this->assertDatabaseMissing('doctor_invitations', [
            'email' => 'doctor@gmail.com',
        ]);
    }

    /** @test */
    public function test_only_valid_emails_can_be_invited()
    {
        Role::create(['name' => 'admin']);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);
        $response = $this->post('api/doctor/invite', [
            'email' => 'invalidemail',
        ]);
        $response->assertStatus(302);
        $this->assertCount(0, DoctorInvitation::all());
    }

    /** @test */
    public function test_cannot_invite_same_email_twice()
    {
        Role::create(['name' => 'admin']);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);
        $this->post('api/doctor/invite', [
            'email' => 'doctor@gmail.com',
        ]);
        $response = $this->post('api/doctor/invite', [
            'email' => 'doctor@gmail.com',
        ]);
        $response->assertStatus(302);
        $this->assertCount(1, DoctorInvitation::all());
    }
}
