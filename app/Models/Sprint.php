<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    protected $fillable = [
        'jira_id',
        'project_id',
        'name',
        'state',
        'start_date',
        'end_date'
    ];

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
