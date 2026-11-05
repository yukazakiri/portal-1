<?php

namespace Tests\Feature\Settings;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Koamishin\Auth\KoamishinUser;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = new KoamishinUser(
            'portal-user-1',
            'Portal User',
            'portal@example.test',
            true,
            'https://portal.example.test/avatar.png',
            metadata: ['private' => 'do-not-share'],
        );

        $response = $this
            ->actingAs($user, 'koamishin')
            ->get('/settings/profile');

        $response->assertInertia(fn ($page) => $page
            ->component('settings/profile')
            ->where('auth.user', [
                'id' => 'portal-user-1',
                'name' => 'Portal User',
                'email' => 'portal@example.test',
                'picture' => 'https://portal.example.test/avatar.png',
                'emailVerified' => true,
            ]));
    }

    public function test_profile_mutations_are_disabled_for_portal_owned_identity(): void
    {
        $this->patch('/settings/profile', [
            'name' => 'Impersonated Name',
            'email' => 'attacker@example.test',
        ])->assertMethodNotAllowed();

        $this->delete('/settings/profile')->assertMethodNotAllowed();
    }
}
