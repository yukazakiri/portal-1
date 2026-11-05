<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_redirects_to_koamishin(): void
    {
        $this->get('/register')->assertRedirect(route('koamishin.register'));
    }

    public function test_local_registration_is_disabled(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertMethodNotAllowed();
        $this->assertDatabaseCount('users', 0);
    }
}
