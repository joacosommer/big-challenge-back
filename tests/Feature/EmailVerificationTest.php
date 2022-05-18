<?php

namespace Tests\Feature;

use App\Models\DoctorInvitation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_email_verification_is_send_when_register_doctor()
    {
        $this->withDeprecationHandling();
        Notification::fake();
        Role::create(['name' => 'doctor']);
        $invitation = DoctorInvitation::factory()->create();
        $response = $this->post('api/doctor/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'phone_number' => '23123123',
            'address' => 'Miami',
            'email' => $invitation['email'],
            'password' => 'password',
            'specialty' => 'Paediatric',
            'bank_account_number' => '123123123',
            'token' => $invitation['token'],
        ]);
        $user = User::first();
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_email_verification_is_send_when_register_patient()
    {
        $this->withDeprecationHandling();
        Notification::fake();
        Role::create(['name' => 'patient']);
        $this->post('api/patient/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'phone_number' => '23123123',
            'address' => 'Miami',
            'email' => 'doe@gmail.com',
            'password' => 'password',
            'weight' => '22',
            'height' => '22',
            'insurance_provider' => 'Aetna',
            'current_medications' => null,
            'allergies' => null,
        ]);
        $user = User::first();
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /** @test */
    public function test_email_verification_is_not_send_if_already_verify()
    {
        $this->withDeprecationHandling();
        Notification::fake();
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('api/email/verification-notification');
        $response->assertJson(['message' => 'Your email address has already been verified.']);
        Notification::assertNotSentTo($user, VerifyEmail::class);
    }

    /** @test */
    public function test_email_verification_is_resend_if_not_verify()
    {
        $this->withDeprecationHandling();
        Notification::fake();
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $this->actingAs($user);
        $response = $this->post('api/email/verification-notification');
        $response->assertJson(['message' => 'Verification email resent successfully.']);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /** @test */
    public function test_registered_event_listener_is_called()
    {
        Event::fake();
        Role::create(['name' => 'doctor']);
        $invitation = DoctorInvitation::factory()->create();
        $response = $this->post('api/doctor/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'phone_number' => '23123123',
            'address' => 'Miami',
            'email' => $invitation['email'],
            'password' => 'password',
            'specialty' => 'Paediatric',
            'bank_account_number' => '123123123',
            'token' => $invitation['token'],
        ]);
        Event::assertDispatched(Registered::class);
    }
}
