<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr; 




class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = Project::query();


        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');
        if ($name = request('name')) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        
        $projects = $query->orderBy($sortField, $sortDirection)->paginate(10)->onEachSide(1);
        $queryParams = request()->query() ?: null;
        return inertia('Project/Index', [
            'projects' => ProjectResource::collection($projects),
            'queryParams' => $queryParams,
            'success' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Project/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
       $data = $request->validated();
    $data['created_by'] = auth()->id(); 
    $data['updated_by'] = auth()->id();

    $image = $request->file('image_path');  
    $projectData = Arr::except($data, ['image_path']); 

    $project = Project::create($projectData);
    if ($image) {
        $path = $image->store('public/project/' . $project->id);
        $project->update(['image_path' => $path]);
    }

    return redirect()->route('project.index', $project)
        ->with('success', 'Project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $query = $project->tasks();
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');
        if ($name = request('name')) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        $tasks = $query->orderBy($sortField, $sortDirection)->paginate(10)->onEachSide(1);
        $queryParams = request()->query() ?: null;
        return inertia('Project/Show', [
            'project' => new ProjectResource($project),
            'tasks' => TaskResource::collection($tasks),
            'queryParams' => $queryParams,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return inertia('Project/Edit', [
            'project' => new ProjectResource($project),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest  $request, Project $project)
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->user()->id;
        $newImage = $request->file('image_path'); 

        if ($newImage) {
            if ($project->image_path) {
                Storage::delete($project->image_path);
            }
            $data['image_path'] = $newImage->store('public/project/' . $project->id);
        }

    $project->update($data);

    return redirect()->route('project.index', $project)
        ->with('success', "Project {$project->name} updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $name = $project->name;
        $project->delete();
        if ($project->image_path) {
            Storage::delete(directory_name($project->image_path));
        }
        return to_route('project.index')->with('success', "Project {$name} deleted successfully ");
    }
}
