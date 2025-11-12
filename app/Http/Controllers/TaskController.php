<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        return inertia('Task/index', [
            'tasks' => $tasks,
            'queryParams' => request()->query() ?: null

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

    /**
     * Display tasks assigned to the authenticated user.
     */
    public function myTasks()
    {
        $user = auth()->user();
        $tasks = Task::with('project')
            ->where('assigned_user_id', $user->id)
            ->get();


        return inertia('Task/index', [
            'tasks' => $tasks
        ]);
    }
}
