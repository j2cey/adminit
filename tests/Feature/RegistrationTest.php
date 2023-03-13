<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function registration_screen_can_be_rendered()
    {
        $this->markTestSkipped('must be revisited.');

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function new_users_can_register()
    {
        $this->markTestSkipped('must be revisited.');

        $response = $this->post('/register', [
            'name' => 'Test UserResource',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
