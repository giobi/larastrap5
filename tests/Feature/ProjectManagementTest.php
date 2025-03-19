<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
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
    public function it_can_display_projects_index_page()
    {
        // Create a client and some test projects
        $client = Client::factory()->create();
        Project::factory()->count(3)->create([
            'client_id' => $client->id
        ]);

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertViewIs('projects.index');
        $response->assertViewHas('projects');
    }

    /** @test */
    public function it_can_create_a_new_project()
    {
        $client = Client::factory()->create();
        
        $projectData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'client_id' => $client->id,
            'status' => 'pending',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(3)->format('Y-m-d'),
        ];

        $response = $this->post(route('projects.store'), $projectData);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'title' => $projectData['title'],
            'client_id' => $client->id,
        ]);
    }

    /** @test */
    public function it_can_show_project_details()
    {
        $client = Client::factory()->create();
        $project = Project::factory()->create([
            'client_id' => $client->id
        ]);

        $response = $this->get(route('projects.show', $project));

        $response->assertStatus(200);
        $response->assertViewIs('projects.show');
        $response->assertViewHas('project');
        $response->assertSee($project->title);
    }

    /** @test */
    public function it_can_update_a_project()
    {
        $client = Client::factory()->create();
        $project = Project::factory()->create([
            'client_id' => $client->id
        ]);

        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'client_id' => $client->id,
            'status' => 'in_progress',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(3)->format('Y-m-d'),
        ];

        $response = $this->put(route('projects.update', $project), $updatedData);

        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Updated Title',
            'status' => 'in_progress',
        ]);
    }

    /** @test */
    public function it_can_delete_a_project()
    {
        $client = Client::factory()->create();
        $project = Project::factory()->create([
            'client_id' => $client->id
        ]);

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));
        $this->assertSoftDeleted('projects', [
            'id' => $project->id,
        ]);
    }

    /** @test */
    public function it_requires_valid_dates_for_project_creation()
    {
        $client = Client::factory()->create();
        
        $projectData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'client_id' => $client->id,
            'status' => 'pending',
            'start_date' => now()->addMonths(1)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'), // End date before start date
        ];

        $response = $this->post(route('projects.store'), $projectData);

        $response->assertSessionHasErrors('end_date');
    }

    /** @test */
    public function it_requires_valid_client_for_project_creation()
    {
        $projectData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'client_id' => 999999, // Non-existent client ID
            'status' => 'pending',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(3)->format('Y-m-d'),
        ];

        $response = $this->post(route('projects.store'), $projectData);

        $response->assertSessionHasErrors('client_id');
    }
} 