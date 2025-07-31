<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
        'unit',
        'department_id',
        'programme_id',
        'lecturer_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('code', 'like', '%' . $search . '%');
    }
}
