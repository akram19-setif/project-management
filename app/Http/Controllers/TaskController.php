<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Task::query();
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
        $tasks = $query->paginate(5);
        $queryParams = request()->query() ?: null;
        return inertia('Task/Index', [
            'tasks' => TaskResource::collection($tasks),
            'success' => $success,
            'queryParams' => $queryParams,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

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
    public function show(Task $task)
    {
        return inertia('Task/Show', [
            'task' => new TaskResource($task),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task) {}

    /**
     * Display tasks assigned to the authenticated user.
     */
    public function myTasks() {}
}
