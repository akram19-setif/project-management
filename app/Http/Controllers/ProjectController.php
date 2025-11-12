<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = Project::query();
        $success = session('success');
        if ($name = request('name')) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($status = request('status')) {
            $query->where('status', $status);
        }
        if ($sortField = request('sort_field')) {
            $sortDirection = request('sort_direction', 'asc');
            $allowedFields = ['id', 'name', 'status', 'created_at', 'due_date'];
            $allowedDirections = ['asc', 'desc'];
            if (in_array($sortField, $allowedFields) && in_array($sortDirection, $allowedDirections)) {
                $query->orderBy($sortField, $sortDirection);
            }
        }
        $projects = $query->paginate(5);
        $queryParams = request()->query() ?: null;
        return inertia('Project/Index', [
            'projects' => ProjectResource::collection($projects),
            'success' => $success,
            'queryParams' => $queryParams,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
