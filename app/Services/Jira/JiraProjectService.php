<?php

namespace App\Services\Jira;

use App\Models\Project;

class JiraProjectService
{
    protected JiraService $client;

    public function __construct(JiraService $jiraService)
    {
        $this->client = $jiraService;
    }

    public function fetchAll(): array
    {
        $projects = $this->client->get('project/search');
        //dd($projects);
        return $projects['values'] ?? [];
    }

    public function syncProjects(): void
    {
        $projects = $this->fetchAll();

        foreach ($projects as $projectData) {
            Project::updateOrCreate(
                ['jira_id' => $projectData['id']],
                [
                    'key' => $projectData['key'],
                    'name' => $projectData['name'],
                ]
            );
        }
    }
}
