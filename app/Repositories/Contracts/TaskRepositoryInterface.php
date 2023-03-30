<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    public function findAll(array $filters, int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): array;

    public function store(array $data): array;

    public function update(int $id, array $data): array;

    public function delete(int $id): bool;

    public function countPendingTasksByUserId(int $userId): int;
}
