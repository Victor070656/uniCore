<?php

namespace App\Livewire\Admin;

use App\Models\AcademicSession;
use Livewire\Component;
use Livewire\WithPagination;

class AcademicSessions extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $academicSessionId;
    public $name;
    public $start_date;
    public $end_date;
    public $is_current;

    public $showModal = false;
    public $editMode = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:academic_sessions,name',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'is_current' => 'boolean',
    ];

    protected $listeners = ['deleteAcademicSession'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function createAcademicSession()
    {
        $this->resetValidation();
        $this->reset(['academicSessionId', 'name', 'start_date', 'end_date', 'is_current']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function storeAcademicSession()
    {
        $this->validate();

        if ($this->is_current) {
            AcademicSession::where('is_current', true)->update(['is_current' => false]);
        }

        AcademicSession::create([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_current' => $this->is_current ?? false,
        ]);

        session()->flash('message', 'Academic Session created successfully.');
        $this->showModal = false;
    }

    public function editAcademicSession($id)
    {
        $this->resetValidation();
        $academicSession = AcademicSession::findOrFail($id);
        $this->academicSessionId = $academicSession->id;
        $this->name = $academicSession->name;
        $this->start_date = $academicSession->start_date->format('Y-m-d');
        $this->end_date = $academicSession->end_date->format('Y-m-d');
        $this->is_current = $academicSession->is_current;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateAcademicSession()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:academic_sessions,name,' . $this->academicSessionId,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        $academicSession = AcademicSession::findOrFail($this->academicSessionId);

        if ($this->is_current && ! $academicSession->is_current) {
            AcademicSession::where('is_current', true)->update(['is_current' => false]);
        }

        $academicSession->update([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_current' => $this->is_current ?? false,
        ]);

        session()->flash('message', 'Academic Session updated successfully.');
        $this->showModal = false;
    }

    public function deleteAcademicSessionConfirm($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    public function deleteAcademicSession($id)
    {
        AcademicSession::destroy($id);
        session()->flash('message', 'Academic Session deleted successfully.');
    }

    public function render()
    {
        $academicSessions = AcademicSession::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.academic-sessions', [
            'academicSessions' => $academicSessions,
        ]);
    }
}
