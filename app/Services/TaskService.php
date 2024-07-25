<?php

namespace App\Services;

use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;



/**
 * Class TaskService
 *
 * This service class handles the business logic for task management
 * and interacts with the TaskRepositoryInterface.
 */
class TaskService
{

    // Instance of TaskRepositoryInterface
    protected $taskRepository;


    // Constructor to bind the TaskRepositoryInterface implementation.
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        // Assigns the repository instance to the class property
        $this->taskRepository = $taskRepository;
    }


    public function getAllTasks(): Collection
    {
        // Delegates the call to the repository to get all tasks
        return $this->taskRepository->all();
    }


    public function getTaskById($id)
    {
        // Delegates the call to the repository to find a task by its ID
        return $this->taskRepository->find($id);
    }


    public function createTask(array $data)
    {
        // Delegates the call to the repository to create a new task
        return $this->taskRepository->create($data);
    }


    public function updateTask(int $id, array $data)
    {
        // Delegates the call to the repository to update the task
        return $this->taskRepository->update($id, $data);
    }

    public function deleteTask(int $id)
    {
        // Delegate the call to the repository to delete the task
        return $this->taskRepository->delete($id);
    }
}
