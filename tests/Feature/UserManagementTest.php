<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UserManagementTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user and authenticate
        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $this->actingAs($admin);
    }

    /** @test */
    public function it_can_create_a_new_user()
    {
        $userData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $userData);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
        ]);

        $response->assertRedirect(route('user.index'));
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();
        
        $updatedData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->put("/user/{$user->id}", $updatedData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $updatedData['email'],
            'first_name' => $updatedData['first_name'],
            'last_name' => $updatedData['last_name'],
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->delete("/user/{$user->id}");

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function it_cannot_create_user_with_duplicate_email()
    {
        $existingUser = User::factory()->create();

        $userData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $existingUser->email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $userData);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_requires_valid_email_for_user_creation()
    {
        $userData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $userData);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_requires_password_confirmation_to_match()
    {
        $userData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ];

        $response = $this->post(route('user.store'), $userData);

        $response->assertSessionHasErrors('password');
    }
} 