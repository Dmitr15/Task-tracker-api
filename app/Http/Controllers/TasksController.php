<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class TasksController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'string|max:1024'
            ]);

            $task = Task::create($request->only(['title', 'description', 'status']));



            Log::info("Task created successfully");

            return response()->json([
                'success' => true,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'status' => $request->input('status')
            ], 200);

        } catch (ValidationException $e) {
            Log::error("Failed task creation!");

            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function index()
    {
        return Task::orderBy('created_at')->get();
    }

    public function show($id)
    {
        return Task::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->only(['title', 'description', 'status']));
    }

    public function delete($id): JsonResponse
    {
        // $task = Task::findOrFail($id);
        // $task->delete();

        $destroyTask = Task::destroy($id);

        return response()->json([
            'success' => $destroyTask,
            'task id' => $id
        ]);
    }


}
