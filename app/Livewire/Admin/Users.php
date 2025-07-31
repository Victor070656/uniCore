<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $userId;
    public $firstname;
    public $lastname;
    public $email;
    public $role;
    public $password;
    public $password_confirmation;

    public $showModal = false;
    public $editMode = false;

    protected $rules = [
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ];

    protected $listeners = ['deleteUser'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function createUser()
    {
        $this->resetValidation();
        $this->reset(['userId', 'firstname', 'lastname', 'email', 'role', 'password', 'password_confirmation']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function storeUser()
    {
        $this->validate();

        User::create([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'role' => $this->role,
            'password' => bcrypt($this->password),
        ]);

        session()->flash('message', 'User created successfully.');
        $this->showModal = false;
    }

    public function editUser($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateUser()
    {
        $this->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required|string',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        if (! empty($this->password)) {
            $this->validate(['password' => 'required|string|min:8|confirmed']);
            $user->update(['password' => bcrypt($this->password)]);
        }

        session()->flash('message', 'User updated successfully.');
        $this->showModal = false;
    }

    public function deleteUserConfirm($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        session()->flash('message', 'User deleted successfully.');
    }

    public function render()
    {
        $users = User::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.users', [
            'users' => $users,
        ]);
    }
}
