<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;


class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $token;
    protected $taskId;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Manually authenticate
        $this->actingAs($user);

        // Create a task
        $task = Task::create([
            'title' => 'Sample Task',
            'description' => 'This is a sample task.',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);

        $this->token = $user->createToken('TestToken')->plainTextToken;
        $this->taskId = $task->id;
    }

    public function test_register()
    {
        $response = $this->post('/api/register', [
            'name' => 'Test',
            'email' => 'testt@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['token']);
    }

    public function test_login()
    {
        // Ensure the user exists
        $user = \App\Models\User::factory()->create([
            'email' => 'testt@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/api/login', [
            'email' => 'testt@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);

        // Store token for subsequent requests
        $this->token = $response->json('token');
    }

    public function test_create_task()
    {
        $this->test_login(); // Ensure token is set

        $response = $this->post('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
        ], ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(201);
        $this->taskId = $response->json('id');
    }


    public function test_read_task()
    {
        $response = $this->get("/api/tasks/{$this->taskId}", [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Sample Task']);
    }

    public function test_update_task()
    {
        $response = $this->put("/api/tasks/{$this->taskId}", [
            'title' => 'Updated Task',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Updated Task']);
    }

    public function test_delete_task()
    {
        $response = $this->delete("/api/tasks/{$this->taskId}", [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200); // Change to 204 if your API returns 204 on successful deletion
        $response->assertJsonFragment(['message' => 'Task deleted successfully.']);
    }



}
