<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Semester Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Manage Semesters
                    </div>
                    <div class="mt-6 text-gray-500">
                        Here you can manage all semesters in the system.
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search semesters..."
                            class="form-input rounded-md shadow-sm mt-1 block w-1/3">
                        <button wire:click="createSemester()"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Semester
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
                                <th wire:click="sortBy('name')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Semester Name
                                    @if ($sortField === 'name')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('academic_session_id')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Academic Session
                                    @if ($sortField === 'academic_session_id')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($semesters as $semester)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $semester->name }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $semester->academicSession->name }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <button wire:click="editSemester({{ $semester->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <button wire:click="deleteSemesterConfirm({{ $semester->id }})"
                                            class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $semesters->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Semester Modal -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div
                    class="modal-content py-4 text-left px-6 flex justify-between items-center pb-3 border-b border-gray-200">
                    <h3 class="text-2xl font-bold">{{ $editMode ? 'Edit Semester' : 'Create Semester' }}</h3>
                    <button wire:click="$set('showModal', false)" class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="{{ $editMode ? 'updateSemester' : 'storeSemester' }}" class="p-6">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Semester Name:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" wire:model="name">
                        @error('name')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="academic_session_id" class="block text-gray-700 text-sm font-bold mb-2">Academic Session:</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="academic_session_id" wire:model="academic_session_id">
                            <option value="">Select Academic Session</option>
                            @foreach ($academicSessions as $academicSession)
                                <option value="{{ $academicSession->id }}">{{ $academicSession->name }}</option>
                            @endforeach
                        </select>
                        @error('academic_session_id')
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