<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::all();
        return view('welcome', compact('tasks'));
    }

    public function store() {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'nullable',
            'owner' => 'required'
        ]);
    
        $task = Task::create($attributes);
        return response()->json(['message' => 'Task created', 'task' => $task]);
    }

    public function update(Task $task) {
        $task->update(['isDone' => true]);
        return response()->json(['message' => 'Task updated', 'task' => $task]);
    }
    
    public function destroy(Task $task) {
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}
