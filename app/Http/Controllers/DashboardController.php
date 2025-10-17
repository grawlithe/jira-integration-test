<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::with(['sprints.issues'])->get();

        $data = $projects->map(function($project) {
            $activeSprint = $project->sprints->firstWhere('state', 'active');

            if(!$activeSprint) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'active_sprint' => null,
                    'planned_hours' => 0,
                    'spent_hours' => 0,
                ];
            }

            $planned = $activeSprint->issues->sum('time_estimate') / 3600;
            $spent = $activeSprint->issues->sum('time_spent') / 3600;

            return [
                'id' => $project->id,
                'name' => $project->name,
                'active_sprint' => $activeSprint->name,
                'planned_hours' => round($planned, 1),
                'spent_hours' => round($spent, 1),
            ];
        });

        return inertia('Dashboard', [
            'projects' => $data ?? [],
        ]);
    }
}
