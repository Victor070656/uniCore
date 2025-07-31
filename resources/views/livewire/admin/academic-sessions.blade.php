<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Academic Session Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Manage Academic Sessions
                    </div>
                    <div class="mt-6 text-gray-500">
                        Here you can manage all academic sessions in the system.
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search academic sessions..."
                            class="form-input rounded-md shadow-sm mt-1 block w-1/3">
                        <button wire:click="createAcademicSession()"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Academic Session
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
                                    Session Name
                                    @if ($sortField === 'name')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('start_date')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Start Date
                                    @if ($sortField === 'start_date')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('end_date')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    End Date
                                    @if ($sortField === 'end_date')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('is_current')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Current
                                    @if ($sortField === 'is_current')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($academicSessions as $session)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $session->name }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $session->start_date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $session->end_date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $session->is_current ? 'Yes' : 'No' }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <button wire:click="editAcademicSession({{ $session->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <button wire:click="deleteAcademicSessionConfirm({{ $session->id }})"
                                            class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $academicSessions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Session Modal -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div
                    class="modal-content py-4 text-left px-6 flex justify-between items-center pb-3 border-b border-gray-200">
                    <h3 class="text-2xl font-bold">{{ $editMode ? 'Edit Academic Session' : 'Create Academic Session' }}</h3>
                    <button wire:click="$set('showModal', false)" class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="{{ $editMode ? 'updateAcademicSession' : 'storeAcademicSession' }}" class="p-6">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Session Name:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="name" wire:model="name">
                        @error('name')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                        <input type="date"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="start_date" wire:model="start_date">
                        @error('start_date')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
                        <input type="date"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="end_date" wire:model="end_date">
                        @error('end_date')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="is_current"
                            wire:model="is_current">
                        <label for="is_current" class="ml-2 text-gray-700 text-sm font-bold">Set as Current Session</label>
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