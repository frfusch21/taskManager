<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Log;

class TaskController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        Log::info($user);
        if ($user) {
            $tasks = Task::where('owner', $user->name)->get();
            return view('welcome', compact('tasks','user'));
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
        try {
            $task->update(['isDone' => true]);
            return response()->json(['message' => 'Task updated', 'task' => $task]);
        } catch (\Exception $e) {
            \Log::error('Error Updating Task:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Task update failed'], 500);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json(['message' => 'Task deleted']);
        } catch (\Exception $e) {
            \Log::error('Error Deleting Task:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Task delete failed'], 500);
        }
    }
}
