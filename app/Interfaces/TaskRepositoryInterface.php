<?php

namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function all(): Collection;
    public function find($id): ?Task;
    public function create(array $data): Task;
    public function update(int $id, array $data): ?Task;
    public function delete($id): bool;
}
