<?php

namespace App\Services\Jira;

class JiraBoardService
{
    protected JiraService $client;

    public function __construct(JiraService $jiraService)
    {
        $this->client = $jiraService;
    }

    public function getBoardsForProject(string $projectKey): array
    {
        $response = $this->client->get('rest/agile/1.0/board', [
            'projectKeyOrId' => $projectKey,
        ]);

        return $response['values'] ?? [];
    }

}
