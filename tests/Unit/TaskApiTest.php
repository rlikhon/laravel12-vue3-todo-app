<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_create_a_task()
    {
        $response = $this->actingAs($this->user)->postJson('/api/tasks', [
            'title' => 'Test Task',
            'body' => 'Test body content',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Test Task']);
    }

    /** @test */
    public function user_can_view_their_tasks()
    {
        Task::factory()->for($this->user)->create(['title' => 'My Task']);

        $response = $this->actingAs($this->user)->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'My Task']);
    }

    /** @test */
    public function user_can_update_a_task()
    {
        $task = Task::factory()->for($this->user)->create();

        $response = $this->actingAs($this->user)->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
            'completed' => true,
        ]);

        $response->assertOk()
                 ->assertJsonFragment(['title' => 'Updated Title']);
    }

    /** @test */
    public function user_can_delete_a_task()
    {
        $task = Task::factory()->for($this->user)->create();

        $response = $this->actingAs($this->user)->deleteJson("/api/tasks/{$task->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}