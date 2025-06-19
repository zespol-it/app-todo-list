<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_tasks()
    {
        Task::factory()->create(['title' => 'Test 1']);
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Test 1']);
    }

    /** @test */
    public function it_creates_a_task()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Nowe zadanie',
            'description' => 'Opis'
        ]);
        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Nowe zadanie']);
        $this->assertDatabaseHas('tasks', ['title' => 'Nowe zadanie']);
    }

    /** @test */
    public function it_updates_a_task()
    {
        $task = Task::factory()->create();
        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Zmieniony tytuł'
        ]);
        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Zmieniony tytuł']);
    }

    /** @test */
    public function it_deletes_a_task()
    {
        $task = Task::factory()->create();
        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
} 