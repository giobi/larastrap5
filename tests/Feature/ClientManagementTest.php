<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientManagementTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Create and authenticate an admin user
        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($admin);
    }

    /** @test */
    public function it_can_display_clients_index_page()
    {
        // Create some test clients
        Client::factory()->count(3)->create();

        $response = $this->get(route('clients.index'));

        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
        $response->assertViewHas('clients');
    }

    /** @test */
    public function it_can_create_a_new_client()
    {
        $clientData = [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'notes' => $this->faker->paragraph,
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', [
            'name' => $clientData['name'],
            'email' => $clientData['email'],
        ]);
    }

    /** @test */
    public function it_can_show_client_details()
    {
        $client = Client::factory()->create();

        $response = $this->get(route('clients.show', $client));

        $response->assertStatus(200);
        $response->assertViewIs('clients.show');
        $response->assertViewHas('client');
    }

    /** @test */
    public function it_can_update_a_client()
    {
        $client = Client::factory()->create();
        
        $updatedData = [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'notes' => $this->faker->paragraph,
        ];

        $response = $this->put(route('clients.update', $client), $updatedData);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
        ]);
    }

    /** @test */
    public function it_can_delete_a_client()
    {
        $client = Client::factory()->create();

        $response = $this->delete(route('clients.destroy', $client));

        $response->assertRedirect(route('clients.index'));
        $this->assertSoftDeleted($client);
    }

    /** @test */
    public function it_requires_valid_email_for_client_creation()
    {
        $clientData = [
            'name' => $this->faker->company,
            'email' => 'invalid-email',
            'phone' => $this->faker->phoneNumber,
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_requires_unique_email_for_client_creation()
    {
        $existingClient = Client::factory()->create();

        $clientData = [
            'name' => $this->faker->company,
            'email' => $existingClient->email,
            'phone' => $this->faker->phoneNumber,
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertSessionHasErrors('email');
    }
}
