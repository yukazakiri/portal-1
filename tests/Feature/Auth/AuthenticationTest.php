<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Koamishin\Auth\KoamishinUser;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_route_redirects_to_koamishin(): void
    {
        $this->get('/login')->assertRedirect(route('koamishin.login'));
    }

    public function test_local_password_login_is_disabled(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertMethodNotAllowed();
        $this->assertGuest('koamishin');
        $this->assertDatabaseCount('users', 1);
    }

    public function test_koamishin_users_can_logout(): void
    {
        $user = new KoamishinUser('portal-user-1', 'Portal User', 'portal@example.test', true);

        $response = $this->actingAs($user, 'koamishin')->post('/logout');

        Auth::forgetGuards();
        $this->assertGuest('koamishin');
        $response->assertRedirect('/');
    }
}
