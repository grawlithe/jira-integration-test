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
}
