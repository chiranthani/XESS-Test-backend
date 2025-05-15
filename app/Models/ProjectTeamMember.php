<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTeamMember extends Model
{
   protected $fillable = ['project_id', 'member_user_id'];

   public function staffUser()
    {
        return $this->belongsTo(StaffUser::class, 'member_user_id');
    }

}
