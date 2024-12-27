@extends('layouts.app')
@section('content')
    <div class="max-w-full sm:max-w-md md:max-w-4xl mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Time Tracker</h1>

        <div class="mb-4">
            <input
                type="text"
                id="taskName"
                class="p-3 border border-gray-300 rounded w-full text-base"
                placeholder="Enter task name"
            />
        </div>

        <div class="flex justify-center mb-4">
            <button
                id="startStopButton"
                class="bg-green-500 text-white p-3 rounded w-full sm:w-auto text-base"
                onclick="startStopTimer()"
            >
                Start/Stop
            </button>
        </div>

        <div class="p-3 text-center" id="timerCurrent">
        </div>

        <div class="space-y-4 mt-4">
            <h2 class="text-2xl font-semibold">Task Summary</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                    <tr>
                        <th class="px-2 py-2 sm:px-4 sm:py-2 border">Task Name</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-2 border">Task Status</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-2 border">Started At</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-2 border">Stopped At</th>
                        <th class="px-2 py-2 sm:px-4 sm:py-2 border">Time Spent (hours)</th>
                    </tr>
                    </thead>
                    <tbody id="taskSummary">
                    @foreach($tasks as $task)
                        <tr>
                            <td class="px-2 py-2 sm:px-4 sm:py-2 border">
                                {{$task->taskName()->value()}}
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-2 border">
                                {{$task->status()->value}}
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-2 border">
                                {{$task->firstStartedAt()->format('Y-m-d H:i:s')}}
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-2 border">
                                {{$task->lastStoppedAt()?->format('Y-m-d H:i:s')}}
                            </td>
                            <td class="px-2 py-2 sm:px-4 sm:py-2 border">
                                {{$task->timeElapsedToday()->toHours()}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/time-tracker.js') }}"></script>
@endsection
