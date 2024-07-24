<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(): Collection
    {
        return Task::all();
    }
    public function find($id): ?Task
    {
        $task = Task::find($id);

        if (!$task) {
            return null;
        }
        return $task;
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }


    public function update(int $id, array $data): ?Task
    {
        $task = Task::find($id);

        if (!$task) {
            return null;
        }

        $task->update($data);
        return $task;
    }

    public function delete($id): bool
    {
        $task = Task::find($id);

        if ($task) {
            return $task->delete();
        }

        return false;
    }
}
