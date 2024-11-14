<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'student_project';
    protected $fillable = ['student_id', 'project_id', 'justification'];

    public function students()
    {
        return $this->belongsTo(Student::class);
    }

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }
}
