<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use App\Notifications\ProjectCreatedNotification;




class ProjectService
{
    /**
     * Get all projects.
     */
    public function getAll(): Collection
    {
        //return Project::latest()->get();

        return Cache::remember('projects.all', now()->addMinutes(10), function () {
             return Project::latest()->get();
         });

    }

    /**
     * Get a specific project by ID.
     */
    public function getById(int $id): ?Project
    {
        return Project::find($id);
    }

    /**
     * Create a new project.
     */
    public function create(array $data): Project
    {
        return DB::transaction(function () use ($data) {
        $project = Project::create($data);
       // $project->user->notify(new ProjectCreatedNotification($project));
         Cache::forget('projects.all');
        return $project;
    });
    }

    /**
     * Update an existing project.
     */
    public function update($id, array $data): Project
    {
       /* return DB::transaction(function () use ($project, $data) {
            $project->update($data);
            return $project;
        });*/

         $project = Project::find($id);

    if (!$project) {
        return null;
    }

    $project->update($data);
Cache::forget('projects.all');
    return $project;
    }

    /**
     * Delete a project.
     */
    public function delete(Project $project): bool
    {
        return DB::transaction(function () use ($project) {
            Cache::forget('projects.all');
            return $project->delete();
        });
    }

    

}
