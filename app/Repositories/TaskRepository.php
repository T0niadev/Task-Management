<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{


    public function all(): Collection
    {
        // This fetches and return all tasks from the database.
        return Task::all();
    }



    public function find($id): ?Task
    {

        // This attempt to find a task by its ID.
        $task = Task::find($id);


        // This returns null if no task is found.
        if (!$task) {
            return null;
        }

        // This returns the found task.
        return $task;

    }



    public function create(array $data): Task
    {
        // This creates and returns a new task with the given data.
        return Task::create($data);
    }



    public function update(int $id, array $data): ?Task
    {
        // This attempt to find the task by its ID.
        $task = Task::find($id);


        // This returns null if no task is found.
        if (!$task) {
            return null;
        }


        // This updates the task with the given data.
        $task->update($data);


        // This returns the updated task.
        return $task;
    }



    public function delete($id): bool
    {
        // This attempts to find the task by its ID.
        $task = Task::find($id);


        // If the task is found, delete it and return true.
        if ($task) {
            return $task->delete();
        }

        // If no task is found, return false.
        return false;
    }
}
