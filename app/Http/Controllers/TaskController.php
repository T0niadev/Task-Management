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
        $this->taskService = $taskService;
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return $this->taskService->getAllTasks();
    }

    public function show($id)
    {

        $task = $this->taskService->getTaskById($id);

        if (!$task) {
            return response()->json(['message' => 'Task ID not found.'], 404);
        }

        return response()->json($task, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in-progress,completed',
            'due_date' => 'nullable|date|after_or_equal:today',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = $this->taskService->createTask($request->all());
        return response()->json($task, 201);
    }


    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in-progress,completed',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = $this->taskService->updateTask($id, $request->all());

        if (!$task) {
            return response()->json(['message' => 'Task ID not found.'], 404);
        }

        return response()->json($task, 200);
    }


    public function destroy($id): JsonResponse
    {
        $success = $this->taskService->deleteTask($id);

        if ($success) {
            return response()->json(['message' => 'Task deleted successfully.']);
        }

        return response()->json(['message' => 'Task not found.'], 404);
    }

}
