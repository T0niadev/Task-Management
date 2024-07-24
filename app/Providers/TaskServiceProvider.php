<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interface\TaskRepositoryInterface;
use App\Repositories\TaskRepository;

class TaskServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TaskService::class, function ($app) {
            return new TaskService($app->make(TaskRepositoryInterface::class));
        });
    }

    public function boot()
    {
        //
    }
}
