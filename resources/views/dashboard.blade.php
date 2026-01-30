<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Taskboard</h2>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'multi-task-modal')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            + add a Task
        </button>
    </div>
    <!-- Add Task Modal -->
    <div
        x-data="{ open: false }"
        x-on:open-modal.window="if($event.detail == 'multi-task-modal') open = true"
        x-show="open"
        class="fixed inset-0 flex items-center justify-center z-50">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50" x-on:click="open = false"></div>

        <!-- Modal Panel -->
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 p-6 z-10"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Add New Task</h2>

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <select name="priority" id="priority"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="todo" selected>To Do</option>
                        <option value="in_progress">In Progress</option>
                        <option value="done">Done</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Add Task</button>
                </div>
            </form>
        </div>
    </div>

    <div x-data="{ activeTab: 'all' }" class="space-y-6">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm font-medium text-gray-500">Total Tasks</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-amber-50 p-6 rounded-xl shadow-sm border border-amber-100">
                <p class="text-sm font-medium text-amber-600">To Do</p>
                <p class="text-2xl font-bold text-amber-900">{{ $stats['todo'] }}</p>
            </div>
            <div class="bg-blue-50 p-6 rounded-xl shadow-sm border border-blue-100">
                <p class="text-sm font-medium text-blue-600">In Progress</p>
                <p class="text-2xl font-bold text-blue-900">{{ $stats['in_progress'] }}</p>
            </div>
            <div class="bg-emerald-50 p-6 rounded-xl shadow-sm border border-emerald-100">
                <p class="text-sm font-medium text-emerald-600">Completed</p>
                <p class="text-2xl font-bold text-emerald-900">{{ $stats['done'] }}</p>
            </div>
            <div class="bg-red-50 p-6 rounded-xl shadow-sm border border-red-100">
                <p class="text-sm font-medium text-red-600">Overdue</p>
                <p class="text-2xl font-bold text-red-900">{{ $stats['overdue'] }}</p>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="bg-white p-4 rounded-lg shadow-sm flex flex-wrap gap-4 items-center justify-between">
            <div class="flex flex-1 min-w-[300px] relative">
                <input type="text" placeholder="Search tasks..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            </div>
            <div class="flex items-center gap-3">
                <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                    <option>All Priorities</option>
                    <option>High</option>
                    <option>Medium</option>
                    <option>Low</option>
                </select>
                <button class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Deadline
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex border-b border-gray-200">
            <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">All Tasks</button>
            <button @click="activeTab = 'todo'" :class="activeTab === 'todo' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">To Do</button>
            <button @click="activeTab = 'in-progress'" :class="activeTab === 'in-progress' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">In Progress</button>
            <button @click="activeTab = 'done'" :class="activeTab === 'done' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Done</button>
        </div>

        <!-- Tasks Table -->
        <!-- Tasks Table -->
        <div class="overflow-x-auto bg-white shadow rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Task</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Task Title & Description -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $task->title }}</div>
                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ $task->description }}</div>
                        </td>

                        <!-- Priority -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                            $priorityColors = [
                            'low' => 'bg-green-100 text-green-800',
                            'medium' => 'bg-yellow-100 text-yellow-800',
                            'high' => 'bg-red-100 text-red-800',
                            ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $priorityColors[$task->priority] ?? '' }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $task->status }}">
                                @if($task->status == 'todo')
                                To Do
                                @elseif($task->status == 'in_progress')
                                In Progress
                                @elseif($task->status == 'done')
                                Done
                                @endif
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="px-3 py-1 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-md transition">Edit</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-red-600 hover:text-white hover:bg-red-600 rounded-md transition" onclick="return confirm('Delete this task?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center text-gray-400 text-sm">
                            No tasks found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>




</x-app-layout>