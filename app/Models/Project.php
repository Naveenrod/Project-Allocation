<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'team_size',
        'trimester',
        'year',
        'industry_partner_id', // Foreign key referencing industry_partners table
    ];

    public function industryPartner()
    {
        return $this->belongsTo(IndustryPartner::class, 'industry_partner_id');
    }

    public function applicants()
    {
        return $this->belongsToMany(Student::class, 'student_project')->withPivot('justification')->withTimestamps();
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

}
