<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_and_get_the_token()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('secret'),
        ]);

        $data = [
            'email' => $user->email,
            'password' => 'secret',
        ];

        $this->json('POST', '/api/login', $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                 'token',
                 'user',
            ]);
    }
}
