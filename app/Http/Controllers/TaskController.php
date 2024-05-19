<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Task;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    
    public function index()
    {
        if (Auth::check()) {
            $tasks = Task::where('owner', $user->name)->get();

            return view('tasks.index', compact('tasks'));
        } else {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'owner' => 'required'
        ]);

        try {
            $task = Task::create($attributes);
            \Log::info('Task Created:', $task->toArray());
            return response()->json(['message' => 'Task created', 'task' => $task], 201);
        } catch (\Exception $e) {
            \Log::error('Error Creating Task:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Task creation failed'], 500);
        }
    }

    public function update(Task $task)
    {
        $task->update(['isDone' => true]);
        return response()->json(['message' => 'Task updated', 'task' => $task]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}
