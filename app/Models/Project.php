<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name','assumed_hours'];

     public function teamMembers()
    {
        return $this->hasMany(ProjectTeamMember::class);
    }
}
