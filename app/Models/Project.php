<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['jira_id', 'key', 'name'];

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }
}
