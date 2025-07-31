<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'faculty_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function programmes()
    {
        return $this->hasMany(Programme::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function lecturers()
    {
        return $this->hasMany(LecturerProfile::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }
}
