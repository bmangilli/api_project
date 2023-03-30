<?php

namespace App\Services\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface TaskServiceInterface
{
    public function getAllTasks(array $filters, int $perPage = 15): LengthAwarePaginator;

    public function getTaskById(int $id): array;

    public function storeTask(array $data): array;

    public function updateTask(int $id, array $data): array;

    public function deleteTask(int $id): void;
}
