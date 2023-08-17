<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegisterSuccess()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'response' => '201',
                'success' => true,
                'message' => 'Register successfully.',
                'data' => [
                    'name' => 'John Doe',
                    'email' => 'john@example.com',
                    'password' => 'password123',
                ]
            ]);

    }

    public function testRegisterFailed()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => '',
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'response' => '400',
                'success' => false,
                'message' => [
                    'name' => [
                      'The name field is required.'
                    ],
                    'email' => [
                        'The email field is required.'
                    ],
                    'password' => [
                        'The password field is required.'
                    ]
                ],
            ]);

    }

    public function testRegisterEmailAlreadyExists()
    {
        User::factory()->create([
            'email' => 'john@example.com',
        ]);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'response' => '400',
                'success' => false,
                'message' => [
                    'email' => [
                        'The email has already been taken.'
                    ]
                ],
            ]);
    }
    
    public function testLoginSuccess(){

        $this->seed([UserSeeder::class]);

        $user = User::first();
        $password = 'password123';

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'response' => '200',
                'success' => true,
                'message' => 'JWT Token refresh Successfully',
            ])
            ->assertJsonStructure([
                'data' => [
                    'token_type',
                    'expires_in',
                    'access_token',
                ],
            ]);
        $this->assertTrue(Hash::check($password, $user->password));
    }
    

    public function testLoginFailed(){
        $this->seed([UserSeeder::class]);

        $user = User::first();
        $password = 'passwordWrong';

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'response' => '401',
                'success' => false,
                'message' => 'Username or password wrong',
            ]);
    }
}
