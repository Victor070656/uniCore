<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Department;
use App\Models\Programme;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Courses extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $courseId;
    public $title;
    public $code;
    public $unit;
    public $department_id;
    public $programme_id;
    public $lecturer_id;

    public $showModal = false;
    public $editMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'code' => 'required|string|max:255|unique:courses,code',
        'unit' => 'required|integer|min:1',
        'department_id' => 'required|exists:departments,id',
        'programme_id' => 'required|exists:programmes,id',
        'lecturer_id' => 'nullable|exists:users,id',
    ];

    protected $listeners = ['deleteCourse'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function createCourse()
    {
        $this->resetValidation();
        $this->reset(['courseId', 'title', 'code', 'unit', 'department_id', 'programme_id', 'lecturer_id']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function storeCourse()
    {
        $this->validate();

        Course::create([
            'name' => $this->name,
            'code' => $this->code,
            'credits' => $this->credits,
            'department_id' => $this->department_id,
            'programme_id' => $this->programme_id,
            'lecturer_id' => $this->lecturer_id,
        ]);

        session()->flash('message', 'Course created successfully.');
        $this->showModal = false;
    }

    public function editCourse($id)
    {
        $this->resetValidation();
        $course = Course::findOrFail($id);
        $this->courseId = $course->id;
        $this->name = $course->name;
        $this->code = $course->code;
        $this->credits = $course->credits;
        $this->department_id = $course->department_id;
        $this->programme_id = $course->programme_id;
        $this->lecturer_id = $course->lecturer_id;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function updateCourse()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courses,code,' . $this->courseId,
            'credits' => 'required|integer|min:1',
            'department_id' => 'required|exists:departments,id',
            'programme_id' => 'required|exists:programmes,id',
            'lecturer_id' => 'nullable|exists:users,id',
        ]);

        $course = Course::findOrFail($this->courseId);
        $course->update([
            'name' => $this->name,
            'code' => $this->code,
            'credits' => $this->credits,
            'department_id' => $this->department_id,
            'programme_id' => $this->programme_id,
            'lecturer_id' => $this->lecturer_id,
        ]);

        session()->flash('message', 'Course updated successfully.');
        $this->showModal = false;
    }

    public function deleteCourseConfirm($id)
    {
        $this->dispatch('confirm-delete', $id);
    }

    public function deleteCourse($id)
    {
        Course::destroy($id);
        session()->flash('message', 'Course deleted successfully.');
    }

    public function render()
    {
        $courses = Course::search($this->search)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $departments = Department::all();
        $programmes = Programme::all();
        $lecturers = User::where('role', 'lecturer')->get();

        return view('livewire.admin.courses', [
            'courses' => $courses,
            'departments' => $departments,
            'programmes' => $programmes,
            'lecturers' => $lecturers,
        ]);
    }
}
