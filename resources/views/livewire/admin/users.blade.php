<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Manage Users
                    </div>
                    <div class="mt-6 text-gray-500">
                        Here you can manage all users in the system.
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search users..."
                            class="form-input rounded-md shadow-sm mt-1 block w-1/3">
                        <button wire:click="createUser()"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New User
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
                                <th wire:click="sortBy('firstname')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    First Name
                                    @if ($sortField === 'firstname')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('lastname')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Last Name
                                    @if ($sortField === 'lastname')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('email')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Email
                                    @if ($sortField === 'email')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th wire:click="sortBy('role')"
                                    class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Role
                                    @if ($sortField === 'role')
                                        <span>{!! $sortDirection === 'asc' ? '&uarr;' : '&darr;' !!}</span>
                                    @endif
                                </th>
                                <th class="px-6 py-3 bg-gray-50"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $user->firstname }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $user->lastname }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap">{{ $user->role }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <button wire:click="editUser({{ $user->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <button wire:click="deleteUserConfirm({{ $user->id }})"
                                            class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Modal -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <div
                    class="modal-content py-4 text-left px-6 flex justify-between items-center pb-3 border-b border-gray-200">
                    <h3 class="text-2xl font-bold">{{ $editMode ? 'Edit User' : 'Create User' }}</h3>
                    <button wire:click="$set('showModal', false)" class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18"
                            height="18" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="{{ $editMode ? 'updateUser' : 'storeUser' }}" class="p-6">
                    <div class="mb-4">
                        <label for="firstname" class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="firstname" wire:model="firstname">
                        @error('firstname')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="lastname" wire:model="lastname">
                        @error('lastname')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <input type="email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" wire:model="email">
                        @error('email')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role:</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="role" wire:model="role">
                            <option value="">Select Role</option>
                            <option value="super-admin">Super Admin</option>
                            <option value="university-admin">University Admin</option>
                            <option value="registrar">Registrar</option>
                            <option value="bursar">Bursar</option>
                            <option value="hod">HOD</option>
                            <option value="lecturer">Lecturer</option>
                            <option value="student">Student</option>
                            <option value="parent">Parent</option>
                            <option value="exams-officer">Exams Officer</option>
                        </select>
                        @error('role')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                        <input type="password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="password" wire:model="password">
                        @error('password')
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm
                            Password:</label>
                        <input type="password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="password_confirmation" wire:model="password_confirmation">
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
