<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;




// index() → list + filter + search

class TaskController extends Controller
{
    public function index()
    {
        //    $tasks = auth()->user()->tasks();
        // $tasks = Auth::user()->tasks();
        // $tasks = User::with('tasks')->first();
            //    dd($tasks);

//              $user=   User::find(1);

// Auth::user()->tasks()->create([
//     'title' => 'Test Task',
//     'description' => 'This is a test task',
//     'deadline' => now()->addDays(3),
//     'priority' => 'medium',
//     'status' => 'todo',
// ]);
   $tasks = Auth::user()->tasks()->get();
        // dd($tasks );

         $stats = [
        'total' => $tasks->count(),
        'todo' => $tasks->where('status', 'todo')->count(),
        'in_progress' => $tasks->where('status', 'in_progress')->count(),
        'done' => $tasks->where('status', 'done')->count(),
        'overdue' => $tasks->where('deadline', '<', now())->where('status', '!=', 'done')->count(),
    ];
        return view('dashboard', compact('tasks','stats'));

        // dd($Tasks);
        


    }

    public function create()
    {
        //  show form
                return view('tasks.create');

    }

    public function store(Request $request)
    {
        // create task
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
        ]);
        Auth::user()->tasks()->create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }
    public function update()
    {
        //  update task
     
    }
    public function delete(Task $task)
    {
        // soft delete
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
    public function updateStatus()
    {
        // AJAX status change
    }
}
