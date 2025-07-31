<?php

namespace App\Livewire\Admin;

use App\Models\Department;
use App\Models\Programme;
use Livewire\Component;
use Livewire\WithPagination;

class Programmes extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $programmeId;
    public $name;
    public $department_id;

    public $showModal = false;
    public $editMode = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:programmes,name',
        'department_id' => 'required|exists:departments,id',
    ];

    protected $listeners = ['deleteProgramme'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function createProgramme()
    {
        $this->resetValidation();
        $this->reset(['programmeId', 'name', 'department_id']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function storeProgramme()
    {
        $this->validate();

        Programme::create([
            'name' => $this->name,
            'department_id' => $this->department_id,
        ]);

        session()->flash('message', 'Programme created successfully.');
        $this->showModal = false;
    }

    public function editProgramme($id)
    {
        $this->resetValidation();
        $programme = Programme::findOrFail($id);
        $this->programmeId = $programme->id;
        $this->name = $programme->name;
        $this->department_id = $programme->department_id;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateProgramme()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:programmes,name,' . $this->programmeId,
            'department_id' => 'required|exists:departments,id',
        ]);

        $programme = Programme::findOrFail($this->programmeId);
        $programme->update([
            'name' => $this->name,
            'department_id' => $this->department_id,
        ]);

        session()->flash('message', 'Programme updated successfully.');
        $this->showModal = false;
    }

    public function deleteProgrammeConfirm($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    public function deleteProgramme($id)
    {
        Programme::destroy($id);
        session()->flash('message', 'Programme deleted successfully.');
    }

    public function render()
    {
        $programmes = Programme::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $departments = Department::all();

        return view('livewire.admin.programmes', [
            'programmes' => $programmes,
            'departments' => $departments,
        ]);
    }
}
