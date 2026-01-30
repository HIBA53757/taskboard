<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Task
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6 mt-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Update Task
        </h2>

        <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $task->title) }}"
                    required
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea
                    name="description"
                    rows="3"
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >{{ old('description', $task->description) }}</textarea>
            </div>

            <!-- Priority -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Priority</label>
                <select
                    name="priority"
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                >
                    <option value="low" @selected($task->priority === 'low')>Low</option>
                    <option value="medium" @selected($task->priority === 'medium')>Medium</option>
                    <option value="high" @selected($task->priority === 'high')>High</option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select
                    name="status"
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                >
                    <option value="todo" @selected($task->status === 'todo')>To Do</option>
                    <option value="in_progress" @selected($task->status === 'in_progress')>In Progress</option>
                    <option value="done" @selected($task->status === 'done')>Done</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-2">
                <a
                    href="{{ route('tasks.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                >
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
