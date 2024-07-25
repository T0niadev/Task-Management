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

    // Token for authenticated requests
    protected $token;

    // ID of the created task for testing
    protected $taskId;


    /**
     * Set up the test environment.
     *
     * This method is called before each test is run. It creates a user, authenticates the user,
     * and creates a sample task for use in tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticates for testing the tasks
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Manually authenticates
        $this->actingAs($user);

        // Create a task
        $task = Task::create([
            'title' => 'Sample Task',
            'description' => 'This is a sample task.',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);


        // Generates a token for authenticated requests
        $this->token = $user->createToken('TestToken')->plainTextToken;

        // Stores the task ID for use in subsequent tests
        $this->taskId = $task->id;
    }



    /**
     * Test task creation endpoint.
     *
     * Sends a POST request to the /api/tasks endpoint with task data, including the authorization token.
     * Asserts that the response status is 201 and retrieves the task ID for further tests.
     */
    public function test_create_task()
    {
      

        $response = $this->post('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
        ], ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(201);
        $this->taskId = $response->json('id');
    }




    /**
     * Test task retrieval endpoint.
     *
     * Sends a GET request to the /api/tasks/{id} endpoint to retrieve the task by its ID.
     * Asserts that the response status is 200 and verifies the task title in the response.
     */
    public function test_read_task()
    {
        $response = $this->get("/api/tasks/{$this->taskId}", [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Sample Task']);
    }



    /**
     * Test task update endpoint.
     *
     * Sends a PUT request to the /api/tasks/{id} endpoint to update the task with new data.
     * Asserts that the response status is 200 and verifies the updated task title in the response.
    */
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



    /**
     * Test task deletion endpoint.
     *
     * Sends a DELETE request to the /api/tasks/{id} endpoint to delete the task by its ID.
     * Asserts that the response status is 200 (or 204 if your API returns 204 on successful deletion) 
     * and verifies the success message in the response.
    */
    public function test_delete_task()
    {
        $response = $this->delete("/api/tasks/{$this->taskId}", [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200); 
        $response->assertJsonFragment(['message' => 'Task deleted successfully.']);
    }



}
