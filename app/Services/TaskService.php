<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    /**
     * Get all tasks.
     */
    public function getAll(): Collection
    {
        return Task::latest()->get();
    }

    /**
     * Get a specific task by ID.
     */
    public function getById(int $id): ?Task
    {
        return Task::find($id);
    }

    /**
     * Get all tasks for a given project.
     */
    public function getByProjectId(int $projectId): Collection
    {
        return Task::where('project_id', $projectId)
                   ->latest()
                   ->get();
    }

    /**
     * Create a new task.
     */
    public function create(array $data): Task
    {
        return DB::transaction(function () use ($data) {
            return Task::create($data);
        });
    }

    /**
     * Update an existing task.
     */
    public function update($id, array $data): Task
    {
       $task = Task::find($id);

    if (!$task) {
        return null;
    }

    $task->update($data);

    return $task;
       
        /* return DB::transaction(function () use ($task, $data) {
            $task->update($data);
            return $task;
        });*/
    }

    /**
     * Delete a task.
     */
    public function delete(Task $task): bool
    {
        return DB::transaction(function () use ($task) {
            return $task->delete();
        });
    }
}
