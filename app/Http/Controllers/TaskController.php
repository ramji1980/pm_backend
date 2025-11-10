<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ApiResponse;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->getAll();
        return $this->successResponse($tasks, 'Tasks retrieved successfully');
    }

    public function store(Request $request,$projectId)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|string|in:pending,progress,completed',
            'assigned_to' => 'nullable|integer',
            'due_at'    => 'nullable|date',
        ]);
$project = Project::findOrFail($projectId);
        $validated['project_id'] =  $project->id;
        $task = $this->taskService->create($validated);
        return $this->successResponse($task, 'Task created successfully', 201);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return $this->successResponse($task, 'Task details');
    }

    public function update(Request $request, $id)
    {
      //  $this->authorize('update', $task);

        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|string|in:pending,progress,completed',
            'assigned_to' => 'nullable|integer',
        ]);
//dd($validated);

        $updatedTask = $this->taskService->update($id, $validated);
        return $this->successResponse($updatedTask, 'Task updated successfully');
    }

   

     public function destroy($id)
    {
    // Find project
    $task = Task::find($id);

    if (!$task) {
        return $this->errorResponse('Task not found', 404);
    }

    // Optional: check policy (if you use Laravel Policies)
    //$this->authorize('delete', $task);

    // Delete via service
    $this->taskService->delete($task);

    return $this->successResponse(null, 'Task deleted successfully', 200);
}

    /**
     * List tasks by project.
     */
    public function byProject(int $projectId)
    {
        $tasks = $this->taskService->getByProjectId($projectId);
        return $this->successResponse($tasks, 'Tasks for project retrieved successfully');
    }
}
