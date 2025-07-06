<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
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

}
