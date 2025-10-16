<?php

namespace App\Services\Jira;

use App\Models\Sprint;
use Illuminate\Support\Collection;

class JiraSprintService
{
    protected JiraService $client;

    public function __construct(JiraService $jiraService)
    {
        $this->client = $jiraService;
    }

    public function fetchActiveSprints(string $boardId): Array
    {
        $response = $this->client->get("rest/agile/1.0/board/{$boardId}/sprint", [
            'state' => 'active',
        ]);

        return $response['values'] ?? [];
    }

    public function syncActiveSprints(string $projectId, int $boardId): Collection
    {
        $sprints = collect($this->fetchActiveSprints((string)$boardId));

        return $sprints->map(function ($sprintData) use ($projectId) {
            return Sprint::updateOrCreate(
                ['jira_id' => $sprintData['id']],
                [
                    'project_id' => $projectId,
                    'name' => $sprintData['name'],
                    'state' => $sprintData['state'],
                    'start_date' => $sprintData['startDate'] ?? null,
                    'end_date' => $sprintData['endDate'] ?? null,
                ]
            );
        });
    }

}
