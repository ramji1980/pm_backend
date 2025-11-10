<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ApiResponse;

    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        $projects = $this->projectService->getAll();
        return $this->successResponse($projects, 'Projects retrieved successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
          //  'created_by'=> 'required|integer|exists:users,id',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date',
            'status'=>'required|string|in:planning,active,completed,archived,on-hold',

        ]);

            $validated['created_by'] = $request->user()->id;

        $project = $this->projectService->create($validated);
        return $this->successResponse($project, 'Project created successfully', 201);
    }

    public function show($id)
    {
       
      $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        return response()->json($this->projectService->getById($id), 200 );
    }

    public function update(Request $request, $id)
    {
        

        $validated = $request->validate([
        'title' => 'sometimes|required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'sometimes|required|date',
        'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        'status' => 'sometimes|required|string|in:planning,active,completed,archived,on-hold',
    ]);

        $updatedProject = $this->projectService->update($id, $validated);
        return $this->successResponse($updatedProject, 'Project updated successfully');
    }

   public function destroy($id)
{
    // Find project
    $project = Project::find($id);

    if (!$project) {
        return $this->errorResponse('Project not found', 404);
    }

    // Optional: check policy (if you use Laravel Policies)
    //$this->authorize('delete', $project);

    // Delete via service
    $this->projectService->delete($project);

    return $this->successResponse(null, 'Project deleted successfully', 200);
}

}
