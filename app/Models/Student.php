<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'gpa',
        'roles',
    ];

    protected $casts = [
        'roles' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->belongsToMany(Project::class, 'student_project')->withPivot('justification', 'assigned')->withTimestamps();
    }

    public function assignedProject()
    {
        return $this->belongsToMany(Project::class, 'student_project')
                    ->wherePivot('assigned', true)
                    ->withPivot('justification');
    }
}
