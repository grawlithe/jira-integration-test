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

        $boards = $response['values'] ?? [];

        // dd($boards);

        return array_filter($boards, function ($board) {
            return $board['type'] === 'scrum';
        });
    }

}
