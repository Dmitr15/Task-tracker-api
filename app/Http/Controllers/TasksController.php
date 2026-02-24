<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class TasksController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1024',
            'status' => 'nullable|boolean'
        ]);

        $task = Task::create($data);

        Log::info("Task created successfully", ['id' => $task->id]);

        return response()->json($task, 201);
    }

    public function index(): JsonResponse
    {
        $tasks = Task::orderBy('created_at')->get();

        Log::info("List of tasks was returned");

        return response()->json($tasks);
    }

    public function show($id): JsonResponse
    {
        $task = Task::findOrFail($id);
        Log::info('Task found', ['id' => $task->id]);
        return response()->json($task);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1024',
            'status' => 'sometimes|boolean',
        ]);

        $task = Task::findOrFail($id);

        $task->update($data);

        Log::info('Task updated successfully', ['id' => $task->id]);

        return response()->json($task, 200);
    }

    public function destroy($id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->delete();

        Log::info('Task deleted', ['id' => $task->id]);

        return response()->json(null, 204);
    }

}
