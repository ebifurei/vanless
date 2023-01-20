<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_can_see_register_page()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_user_can_see_password_reset_page()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_user_can_create_account()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
        ]);
    }

    // can create user with email_subscribe true
    public function test_user_can_create_account_with_email_subscribe()
    {
        $this->login();

        $response = $this->post(route('user.store'), [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'email_subscribe' => true,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'email_subscribe' => true,
        ]);
    }
}
