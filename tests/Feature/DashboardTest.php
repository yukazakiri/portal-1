<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Koamishin\Auth\KoamishinUser;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/dashboard')->assertRedirect(route('koamishin.login'));
    }

    public function test_local_users_cannot_access_the_koamishin_dashboard(): void
    {
        $this->actingAs(User::factory()->create(), 'web')
            ->get('/dashboard')
            ->assertRedirect(route('koamishin.login'));
    }

    public function test_koamishin_users_can_visit_the_dashboard(): void
    {
        $user = new KoamishinUser('portal-user-1', 'Portal User', 'portal@example.test', true);

        $this->actingAs($user, 'koamishin');
        $this->get('/dashboard')->assertOk();
    }
}
