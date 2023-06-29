<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testRequiredFieldsForRegistration()
    {
        $this->postJson('api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The name field is required. (and 2 more errors)',
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]);
    }

    public function testRepeatPassword()
    {
        $userData = [
            'name' => 'john doe',
            'email' => 'john@example.com',
            'password' => 'john1234'
        ];

        $this->postJson('api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The password confirmation does not match.'
            ]);
    }

    public function testSuccessfullyRegistration()
    {
        $useData = [
            'name' => 'john doe',
            'email' => 'john@example.com',
            'password' => 'john1234',
            'password_confirmation' => 'john1234'
        ];

        $this->postJson('api/register', $useData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'accessToken',
                'message',
            ]);
    }

    public function testMustEnterEmailAndPassword()
    {
        $this->postJson('api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The email field is required. (and 1 more error)',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
    }

    public function testSuccessfulLogin()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('john1234'),
        ]);


        $loginData = ['email' => 'john@example.com', 'password' => 'john1234'];

        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "user" => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
                "accessToken",
                "message"
            ]);

        $this->assertAuthenticated();
    }
}
