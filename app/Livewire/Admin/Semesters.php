<?php

namespace App\Livewire\Admin;

use App\Models\AcademicSession;
use App\Models\Semester;
use Livewire\Component;
use Livewire\WithPagination;

class Semesters extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $semesterId;
    public $name;
    public $academic_session_id;

    public $showModal = false;
    public $editMode = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:semesters,name',
        'academic_session_id' => 'required|exists:academic_sessions,id',
    ];

    protected $listeners = ['deleteSemester'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function createSemester()
    {
        $this->resetValidation();
        $this->reset(['semesterId', 'name', 'academic_session_id']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function storeSemester()
    {
        $this->validate();

        Semester::create([
            'name' => $this->name,
            'academic_session_id' => $this->academic_session_id,
        ]);

        session()->flash('message', 'Semester created successfully.');
        $this->showModal = false;
    }

    public function editSemester($id)
    {
        $this->resetValidation();
        $semester = Semester::findOrFail($id);
        $this->semesterId = $semester->id;
        $this->name = $semester->name;
        $this->academic_session_id = $semester->academic_session_id;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateSemester()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:semesters,name,' . $this->semesterId,
            'academic_session_id' => 'required|exists:academic_sessions,id',
        ]);

        $semester = Semester::findOrFail($this->semesterId);
        $semester->update([
            'name' => $this->name,
            'academic_session_id' => $this->academic_session_id,
        ]);

        session()->flash('message', 'Semester updated successfully.');
        $this->showModal = false;
    }

    public function deleteSemesterConfirm($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    public function deleteSemester($id)
    {
        Semester::destroy($id);
        session()->flash('message', 'Semester deleted successfully.');
    }

    public function render()
    {
        $semesters = Semester::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $academicSessions = AcademicSession::all();

        return view('livewire.admin.semesters', [
            'semesters' => $semesters,
            'academicSessions' => $academicSessions,
        ]);
    }
}
