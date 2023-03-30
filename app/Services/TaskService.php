<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\Contracts\TaskServiceInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;

class TaskService implements TaskServiceInterface
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->taskRepository->findAll($filters, $perPage);
    }

    public function getTaskById(int $id): array
    {
        return $this->taskRepository->findById($id);
    }

    public function storeTask(array $data): array
    {
        $pendingTasksCount = $this->taskRepository->countPendingTasksByUserId($data['user_id']);

        if ($pendingTasksCount >= 3) {
            throw new Exception('User cannot have more than 3 pending tasks at the same time.');
        }

        return $this->taskRepository->store($data);
    }

    public function updateTask(int $id, array $data): array
    {
        $task = $this->taskRepository->findById($id);

        if ($task['status'] === 'completed' && isset($data['status']) && $data['status'] === 'pending') {
            throw new Exception('Cannot change the status from completed to pending.');
        }

        $updated = $this->taskRepository->update($id, $data);
        if (!$updated) {
            throw new Exception(__('messages.error_updating_task'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $updated;
    }

    public function deleteTask(int $id): void
    {
        $deleted = $this->taskRepository->delete($id);
        if (!$deleted) {
            throw new Exception(__('messages.error_deleting_task'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
