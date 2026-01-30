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

     public function edit(Task $task)
    {
        $this->authorizeTask($task);

        return view('tasksEdit', compact('task'));
    }
    public function update(Request $request, Task $task)
    {
        //  update task
        $this->authorizeTask($task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
     
    }
    public function destroy(Task $task)
    {
        // soft delete
       $this->authorizeTask($task);

        $task->delete(); // soft delete

        return back()->with('success', 'Task archived.');}
       
        
         public function restore($id)
    {
        $task = Task::onlyTrashed()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $task->restore();

        return back()->with('success', 'Task restored.');
    }

     public function forceDelete($id)
    {
        $task = Task::onlyTrashed()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $task->forceDelete();

        return back()->with('success', 'Task permanently deleted.');
    }

       
    public function updateStatus(Request $request, Task $task)
    {
        // AJAX status change
         $this->authorizeTask($task);

        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
     private function authorizeTask(Task $task)
    {
        abort_if($task->user_id !== Auth::id(), 403);
    }
}
