<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Services\Contracts\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['title', 'status']);
        $perPage = $request->input('perPage', 15);

        $tasks = $this->taskService->getAllTasks($filters, $perPage);

        return response()->json([
            'message' => __('messages.tasks_retrieved'),
            'data' => $tasks
        ], Response::HTTP_OK);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->getTaskById($id);

        return response()->json([
            'message' => __('messages.task_retrieved'),
            'data' => $task
        ], Response::HTTP_OK);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $request->validated();

        $task = $this->taskService->storeTask($data);

        return response()->json([
            'message' => __('messages.task_created'),
            'data' => $task
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $task = $this->taskService->updateTask($id, $data);

        return response()->json([
            'message' => __('messages.task_updated'),
            'data' => $task
        ], Response::HTTP_OK);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->taskService->deleteTask($id);

        return response()->json(['message' => __('messages.task_deleted')], Response::HTTP_OK);
    }
}
