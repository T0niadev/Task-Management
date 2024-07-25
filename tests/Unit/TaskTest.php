<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TaskService;
use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Mockery;

class TaskTest extends TestCase
{
    
    //Service and repository instances to be used in tests
    protected $taskService;
    protected $taskRepository;


    //This sets up the test environment
    protected function setUp(): void
    {
        parent::setUp();

        // This mocks the TaskRepositoryInterface and initialize the TaskService with the mocked repository
        $this->taskRepository = Mockery::mock(TaskRepositoryInterface::class);
        $this->taskService = new TaskService($this->taskRepository);
    }


    //This cleans up after every test
    protected function tearDown(): void
    {

        // This closes Mockery to avoid memory leaks and clean up mock objects
        Mockery::close();
        parent::tearDown();
    }


    // This test is for retrieving all tasks
    public function test_get_all_tasks()
    {
        // Creates a collection of Task models
        $tasks = new EloquentCollection([new Task(['title' => 'Task 1']), new Task(['title' => 'Task 2'])]);

        // Set expectations for the mock: when `all` is called, it should return the $tasks collection
        $this->taskRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($tasks);

        // Calls the method under test and assert the results    
        $result = $this->taskService->getAllTasks();
        

        
        //These assert that result has 2 tasks and asserts the title of both tasks
        $this->assertCount(2, $result);
        $this->assertEquals('Task 1', $result[0]->title);
        $this->assertEquals('Task 2', $result[1]->title);
    }


    // This test is for retrieving a task by its ID
    public function test_get_task_by_id()
    {
       
        // Creates a Task instance to return when retrieving a task by ID
        $task = new Task(['id' => 1, 'title' => 'Sample Task']);


        // Sets expectations for the mock: when `find` is called with ID 1, return the $task
        $this->taskRepository
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn($task);

    
        // Calls the method under test and assert the results    
        $result = $this->taskService->getTaskById(1);

        $this->assertNotNull($result);
        $this->assertEquals('Sample Task', $result->title);
    }



    // This is a test for creating a new task
    public function test_create_task()
    {
        // Data for the new task to be created
        $taskData = ['title' => 'New Task', 'description' => 'Task description'];


        // Sets expectations for the mock: when `create` is called with $taskData, return a new Task instance
        $this->taskRepository
            ->shouldReceive('create')
            ->with($taskData)
            ->once()
            ->andReturn(new Task($taskData));

        // Call the method under test and assert the results
        $result = $this->taskService->createTask($taskData);

        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals('New Task', $result->title);
    }


    // This is a test for updating an existing task
    public function test_update_task()
    {
        // Data for updating the task
        $taskData = ['title' => 'Updated Task'];

        // Creates a Task instance with the original title and an updated Task instance
        $task = new Task(['id' => 1, 'title' => 'Original Task']);
        $updatedTask = new Task(['id' => 1, 'title' => 'Updated Task']);


        // Sets expectations for the mock: when `update` is called with ID 1 and $taskData, return the updatedTask
        $this->taskRepository
            ->shouldReceive('update')
            ->with(1, $taskData)
            ->once()
            ->andReturn($updatedTask);

        // Calls the method under test and assert the results
        $result = $this->taskService->updateTask(1, $taskData);

        $this->assertInstanceOf(Task::class, $result);
        $this->assertEquals('Updated Task', $result->title);
    }


    // This is a test for deleting an existing task
    public function test_delete_task()
    {
        
        // Creates a Task instance to be deleted
        $task = new Task(['id' => 1, 'title' => 'Task to delete']);

        // Sets expectations for the mock: when `delete` is called with ID 1, return true
        $this->taskRepository
            ->shouldReceive('delete')
            ->with(1)
            ->once()
            ->andReturn(true);

        // Calls the method under test and assert the results
        $result = $this->taskService->deleteTask(1);

        $this->assertTrue($result);
    }
}
