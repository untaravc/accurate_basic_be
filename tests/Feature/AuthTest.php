<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_without_data()
    {
        $response = $this->post('/api/panel/login');

        $response->assertStatus(200)
        ->assertJson([
            'status' => false,
        ]);
    }

    public function test_login_with_false_body(){
        $response = $this->post('/api/panel/login', [
            'email' => 'admin@ab.com',
            'password' => 'false_password',
        ]);

        $response->assertStatus(200)
        ->assertJson([
            'status' => false,
            'text' => 'Email atau password salah.'
        ]);
    }

    public function test_login_with_true_body(){
        $response = $this->post('/api/panel/login', [
            'email' => 'admin@ab.com',
            'password' => 'admin@ab.com',
        ]);

        $response->assertStatus(200)
        ->assertJson([
            'status' => true,
        ]);
    }

    public function test_logout(){
        $user = User::first();
        $response = $this->actingAs($user, 'sanctum')->post('/api/panel/logout');

        $response->assertStatus(200)
        ->assertJson([
            'status' => true,
        ]);
    }

    public function test_get_auth(){
        $user = User::first();
        $response = $this->actingAs($user, 'sanctum')->get('/api/panel/auth');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }
}
