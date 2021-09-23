<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     *  
     */
    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        //Save attributes to array
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post('/project', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/project')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_project_requires_title()
    {
        $attributes = Project::factory()->raw(['title' => '']);
        $this->post('/project', $attributes)->assertSessionHasErrors('title');
    }
    
    /** @test */
    public function a_project_requires_description()
    {
        $attributes = Project::factory()->raw(['description' => '']);
        $this->post('/project', $attributes)->assertSessionHasErrors('description');
    }
}
