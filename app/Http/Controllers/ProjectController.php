<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Jira\JiraService;
use App\Services\Jira\JiraProjectService;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $client = new JiraService();
        $projectService = new JiraProjectService($client);

        $projectService->syncProjects();

        // Logic to list all projects
        return response()->json([
            'projects' => $projectService->fetchAll(),
        ]);
    }

    public function show($projectId)
    {
        // Logic to show a specific project
        return response()->json(['message' => "Details of project {$projectId}"]);
    }

    public function syncAll()
    {
        // Logic to sync all projects
        return response()->json(['message' => 'All projects synced']);
    }
}
