<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $fillable = [
        'jira_id',
        'sprint_id',
        'key',
        'summary',
        'time_estimate',
        'time_spent'
    ];

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function project()
    {
        return $this->sprint->belongsTo(Project::class);
    }
}
