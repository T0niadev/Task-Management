<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interface\TaskRepositoryInterface;
use App\Repositories\TaskRepository;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * This class register bindings in the container.
     *
     * This method binds the TaskRepositoryInterface to the TaskRepository implementation
     * and creates a binding for the TaskService. This ensures that when the TaskService
     * is needed, it will be constructed with an instance of TaskRepositoryInterface.
     *
     * @return void
    */




    public function register()
    {
        // This binds the TaskRepositoryInterface to the TaskRepository implementation meaning
        //that whenever TaskRepositoryInterface is required, an instance of TaskRepository will be provided
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);


        // This binds the TaskService class.
        // This closure is used to create a new instance of TaskService
        // with an instance of TaskRepositoryInterface.
        $this->app->bind(TaskService::class, function ($app) {
            return new TaskService($app->make(TaskRepositoryInterface::class));
        });
    }

    public function boot()
    {
        //
    }
}
