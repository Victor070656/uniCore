<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Manage Courses
                    </div>
                    <div class="mt-6 text-gray-500">
                        Here you can manage all courses in the system.
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search courses..."
                            class="form-input rounded-md shadow-sm mt-1 block w-1/3">
                        <button wire:click="createCourse()"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Course
                        </button>
                    </div>

                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th wire:click="sortBy('title')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Course Title
                                    @if ($sortField === 'title')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('code')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Course Code
                                    @if ($sortField === 'code')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('unit')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Units
                                    @if ($sortField === 'unit')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('department_id')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Department
                                    @if ($sortField === 'department_id')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('programme_id')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Programme
                                    @if ($sortField === 'programme_id')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('lecturer_id')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Assigned Lecturer
                                    @if ($sortField === 'lecturer_id')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($courses as $course)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $course->title }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $course->code }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $course->unit }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $course->department->name }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $course->programme->name }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $course->lecturer ? $course->lecturer->firstname . ' ' . $course->lecturer->lastname : 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <button wire:click="editCourse({{ $course->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <button wire:click="deleteCourseConfirm({{ $course->id }})"
                                            class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Modal -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div
                    class="modal-content py-4 text-left px-6 flex justify-between items-center pb-3 border-b border-gray-200">
                    <h3 class="text-2xl font-bold">{{ $editMode ? 'Edit Course' : 'Create Course' }}</h3>
                    <button wire:click="$set('showModal', false)" class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="{{ $editMode ? 'updateCourse' : 'storeCourse' }}" class="p-6">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Course Title:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="title" wire:model="title">
                        @error('title')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Course Code:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="code" wire:model="code">
                        @error('code')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="unit" class="block text-gray-700 text-sm font-bold mb-2">Units:</label>
                        <input type="number"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="unit" wire:model="unit">
                        @error('unit')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">Department:</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="department_id" wire:model="department_id">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="programme_id" class="block text-gray-700 text-sm font-bold mb-2">Programme:</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="programme_id" wire:model="programme_id">
                            <option value="">Select Programme</option>
                            @foreach ($programmes as $programme)
                                <option value="{{ $programme->id }}">{{ $programme->name }}</option>
                            @endforeach
                        </select>
                        @error('programme_id')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="lecturer_id" class="block text-gray-700 text-sm font-bold mb-2">Assigned Lecturer:</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="lecturer_id" wire:model="lecturer_id">
                            <option value="">Select Lecturer</option>
                            @foreach ($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}">{{ $lecturer->firstname }} {{ $lecturer->lastname }}</option>
                            @endforeach
                        </select>
                        @error('lecturer_id')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ $editMode ? 'Update' : 'Create' }}
                        </button>
                        <button type="button" wire:click="$set('showModal', false)"
                            class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>