<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'user_id',
                        'title',
                        'description',
                        'status',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
        ]);
    }

    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Task Description',
            'status' => 'pending',
            'user_id' => $user->id,
        ];

        $response = $this->actingAs($user, 'api')->postJson('/api/tasks', $taskData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'user_id',
                'title',
                'description',
                'status',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function testShow(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'message' => __('messages.task_retrieved'),
            'data' => [
                'id' => $task->id,
                'user_id' => $user->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
            ],
        ]);
    }

    public function testUpdate(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $updatedTaskData = [
            'title' => 'Updated Task Title',
            'description' => 'Updated Task Description',
            'status' => 'completed',
        ];

        $response = $this->actingAs($user, 'api')->putJson("/api/tasks/{$task->id}", $updatedTaskData);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => __('messages.task_updated'),
            'data' => [
                'id' => $task->id,
                'user_id' => $user->id,
                'title' => $updatedTaskData['title'],
                'description' => $updatedTaskData['description'],
                'status' => $updatedTaskData['status'],
            ],
        ]);
    }

    public function testDelete(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'message' => __('messages.task_deleted'),
        ]);
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }
}
