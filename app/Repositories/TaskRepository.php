<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function findAll(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->task->query();

        if (!empty($filters['title'])) {
            $query->where('title', 'like', "%{$filters['title']}%");
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): array
    {
        return $this->task->findOrFail($id)->toArray();
    }

    public function store(array $data): array
    {
        return $this->task->create($data)->toArray();
    }

    public function update(int $id, array $data): array
    {
        $task = $this->task->findOrFail($id);
        return $task->update($data) ? $task->toArray() : [];
    }

    public function delete(int $id): bool
    {
        return $this->task->findOrFail($id)->delete();
    }

    public function countPendingTasksByUserId(int $userId): int
    {
        return $this->task->where('user_id', $userId)->where('status', 'pending')->count();
    }
}
