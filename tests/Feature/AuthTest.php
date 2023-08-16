<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
        $existingUser = \App\Models\User::factory()->create([
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
}
