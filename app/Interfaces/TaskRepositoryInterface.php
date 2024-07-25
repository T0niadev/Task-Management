<?php

namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;



/**
 * Interface TaskService
 *
 * This interface defines the methods for managing tasks within the application.
 * It outlines the operations available for tasks, including retrieving, creating,
 * updating, and deleting tasks.
*/
interface TaskRepositoryInterface
{
    //This retrieves a collection of all tasks.
    public function all(): Collection;


    /** This finds a task by its ID.
    * @param int|string $id The ID of the task to find.
    * @return Task|null The found task, or null if not found.
    */
    public function find($id): ?Task;



    /**
     * This creates a new task.
     *
     * @param array $data The data needed to create a task.
     * @return Task The created task instance.
     */
    public function create(array $data): Task;



    /**
     * This updates an existing task.
     *
     * @param int $id The ID of the task to update.
     * @param array $data The data to update the task with.
     * @return Task|null The updated task instance, or null if the task was not found.
     */
    public function update(int $id, array $data): ?Task;


    /**
     * This deletes a task by its ID.
     *
     * @param int|string $id The ID of the task to delete.
     * @return bool True if the task was deleted successfully, false otherwise.
     */
    public function delete($id): bool;
}
