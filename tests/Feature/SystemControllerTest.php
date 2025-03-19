<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SystemControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_shows_system_information_page()
    {
        $response = $this->get('/system');

        $response->assertStatus(200);
        $response->assertViewIs('system.index');
        $response->assertSeeText('System Information');
        $response->assertSeeText('Weather Information');
        $response->assertSeeText('Application Information');
    }

    /** @test */
    public function it_contains_required_system_information()
    {
        $response = $this->get('/system');

        $response->assertStatus(200);
        $response->assertSeeText('PHP Version');
        $response->assertSeeText('Laravel Version');
        $response->assertSeeText('Cache Information');
        $response->assertSeeText('Session Information');
    }

    /** @test */
    public function it_requires_authentication()
    {
        auth()->logout();
        
        $response = $this->get('/system');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function it_displays_cache_information()
    {
        $response = $this->get('/system');

        $response->assertStatus(200);
        $response->assertSeeText('Driver');
        $response->assertSeeText('Path');
    }
} 