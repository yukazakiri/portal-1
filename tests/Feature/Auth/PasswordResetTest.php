<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_local_password_reset_routes_are_disabled(): void
    {
        $this->get('/forgot-password')->assertRedirect(route('koamishin.login'));
        $this->post('/forgot-password', ['email' => 'portal@example.test'])->assertMethodNotAllowed();
        $this->get('/reset-password/test-token')->assertRedirect(route('koamishin.login'));
        $this->post('/reset-password')->assertNotFound();
    }
}
