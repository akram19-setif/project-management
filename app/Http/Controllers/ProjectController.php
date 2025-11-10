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

        $projects  = Project::paginate(10)->onEachSide(1);
        $success = session('success');
        if (request("name")) {
            $projects = $projects->where('name', 'like', '%' . request('name') . '%');
        }
        if (request("status")) {
            $projects = $projects->where('status', request('status'));
        }
        $queryParams = request()->query() ?: [];
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
