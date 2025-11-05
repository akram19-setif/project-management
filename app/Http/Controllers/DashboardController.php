<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Count total tasks by status
        $totalPendingTasks = Task::where('status', 'pending')->count();
        $totalProgressTasks = Task::where('status', 'in_progress')->count();
        $totalCompletedTasks = Task::where('status', 'completed')->count();

        // Count user's tasks by status
        $myPendingTasks = Task::where('status', 'pending')
            ->where('assigned_user_id', $user->id)
            ->count();

        $myProgressTasks = Task::where('status', 'in_progress')
            ->where('assigned_user_id', $user->id)
            ->count();

        $myCompletedTasks = Task::where('status', 'completed')
            ->where('assigned_user_id', $user->id)
            ->count();

        // Get user's active tasks (pending and in_progress) with project data
        $activeTasks = Task::with('project')
            ->where('assigned_user_id', $user->id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        return Inertia::render('Dashboard', [
            'totalPendingTasks' => $totalPendingTasks,
            'myPendingTasks' => $myPendingTasks,
            'totalProgressTasks' => $totalProgressTasks,
            'myProgressTasks' => $myProgressTasks,
            'totalCompletedTasks' => $totalCompletedTasks,
            'myCompletedTasks' => $myCompletedTasks,
            'activeTasks' => $activeTasks,
        ]);
    }
}
