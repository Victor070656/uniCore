<?php

namespace App\Livewire\Admin;

use App\Models\Faculty;
use Livewire\Component;
use Livewire\WithPagination;

class Faculties extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $facultyId;
    public $name;

    public $showModal = false;
    public $editMode = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:faculties,name',
    ];

    protected $listeners = ['deleteFaculty'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function createFaculty()
    {
        $this->resetValidation();
        $this->reset(['facultyId', 'name']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function storeFaculty()
    {
        $this->validate();

        Faculty::create([
            'name' => $this->name,
        ]);

        session()->flash('message', 'Faculty created successfully.');
        $this->showModal = false;
    }

    public function editFaculty($id)
    {
        $this->resetValidation();
        $faculty = Faculty::findOrFail($id);
        $this->facultyId = $faculty->id;
        $this->name = $faculty->name;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateFaculty()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:faculties,name,' . $this->facultyId,
        ]);

        $faculty = Faculty::findOrFail($this->facultyId);
        $faculty->update([
            'name' => $this->name,
        ]);

        session()->flash('message', 'Faculty updated successfully.');
        $this->showModal = false;
    }

    public function deleteFacultyConfirm($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    public function deleteFaculty($id)
    {
        Faculty::destroy($id);
        session()->flash('message', 'Faculty deleted successfully.');
    }

    public function render()
    {
        $faculties = Faculty::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.faculties', [
            'faculties' => $faculties,
        ]);
    }
}
