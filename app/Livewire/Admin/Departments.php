<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use App\Models\Faculty;
use Livewire\Component;
use Livewire\WithPagination;

class Departments extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $departmentId;
    public $name;
    public $faculty_id;

    public $showModal = false;
    public $editMode = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:departments,name',
        'faculty_id' => 'required|exists:faculties,id',
    ];

    protected $listeners = ['deleteDepartment'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function createDepartment()
    {
        $this->resetValidation();
        $this->reset(['departmentId', 'name', 'faculty_id']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function storeDepartment()
    {
        $this->validate();

        Department::create([
            'name' => $this->name,
            'faculty_id' => $this->faculty_id,
        ]);

        session()->flash('message', 'Department created successfully.');
        $this->showModal = false;
    }

    public function editDepartment($id)
    {
        $this->resetValidation();
        $department = Department::findOrFail($id);
        $this->departmentId = $department->id;
        $this->name = $department->name;
        $this->faculty_id = $department->faculty_id;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateDepartment()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $this->departmentId,
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        $department = Department::findOrFail($this->departmentId);
        $department->update([
            'name' => $this->name,
            'faculty_id' => $this->faculty_id,
        ]);

        session()->flash('message', 'Department updated successfully.');
        $this->showModal = false;
    }

    public function deleteDepartmentConfirm($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    public function deleteDepartment($id)
    {
        Department::destroy($id);
        session()->flash('message', 'Department deleted successfully.');
    }

    public function render()
    {
        $departments = Department::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $faculties = Faculty::all();

        return view('livewire.admin.departments', [
            'departments' => $departments,
            'faculties' => $faculties,
        ]);
    }
}
