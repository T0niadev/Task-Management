<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{

    protected $taskService;

    public function __construct(TaskService $taskService)
    {

        /**
         * This injects the TaskService dependency into the controller.
         * This allows the TaskController to use the TaskService for handling
         * task-related business logic.
         */
        $this->taskService = $taskService;

        //This applies Sanctum authentication middleware to all methods
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        // This retrieves and return all tasks
        return $this->taskService->getAllTasks();
    }

    public function show($id)
    {

        // This retrieves the task by its ID
        $task = $this->taskService->getTaskById($id);


        // This returns 404 if task not found
        if (!$task) {
            return response()->json(['message' => 'Task ID not found.'], 404);
        }

        // This returns the task details
        return response()->json($task, 200);
    }

    public function store(Request $request)
    {

        // This validates the request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in-progress,completed',
            'due_date' => 'nullable|date|after_or_equal:today',

        ]);


        // This returns validation errors if any
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // This reate the task with validated data
        $task = $this->taskService->createTask($request->all());


        // This returns the created task with 201 status code
        return response()->json($task, 201);
    }


    public function update(Request $request, int $id): JsonResponse
    {

        // This validates the request data
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in-progress,completed',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);


        // This returns validation errors if any
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        // This updates the task with validated data
        $task = $this->taskService->updateTask($id, $request->all());


        // This returns 404 if task not found
        if (!$task) {
            return response()->json(['message' => 'Task ID not found.'], 404);
        }

        return response()->json($task, 200);
    }


    public function destroy($id): JsonResponse
    {

        // This attempts to delete the task by its ID
        $success = $this->taskService->deleteTask($id);


        //This returns success message if deletion was successful
        if ($success) {
            return response()->json(['message' => 'Task deleted successfully.']);
        }

        // This returns 404 if task not found
        return response()->json(['message' => 'Task not found.'], 404);
    }

}
