<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase

{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'first_name' => 'Mikaela',
            'last_name' => 'Chausheva',
            'email' => 'mikaela@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'student',
        ]);

        $response->assertRedirect('/login');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'mikaela@example.com',
        ]);
    }
}
