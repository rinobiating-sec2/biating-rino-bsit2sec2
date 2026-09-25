@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Personal Task Manager</h1>
    <a href="/tasks/create" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">+ Add Task</a>
</div>

<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b bg-gray-50">
                <th class="p-3">Task Name</th>
                <th class="p-3">Description</th>
                <th class="p-3">Due Date</th>
                <th class="p-3">Status</th>
                <th class="p-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 font-medium">{{ $task->task_name }}</td>
                    <td class="p-3 text-sm text-gray-600">{{ $task->description ?? 'N/A' }}</td>
                    <td class="p-3 text-sm">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No deadline' }}</td>
                    <td class="p-3">
                        <form action="/tasks/{{ $task->id }}/toggle" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-1 text-xs rounded-full {{ $task->status === 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $task->status }}
                            </button>
                        </form>
                    </td>
                    <td class="p-3 text-right space-x-2">
                        <a href="/tasks/{{ $task->id }}/edit" class="text-blue-600 hover:underline">Edit</a>
                        <form action="/tasks/{{ $task->id }}" method="POST" class="inline" onsubmit="return confirm('Delete this task?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">No tasks found. Click "Add Task" to create one.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
