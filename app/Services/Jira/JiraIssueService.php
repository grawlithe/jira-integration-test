<?php

namespace App\Services\Jira;

use App\Models\Issue;
use Illuminate\Support\Collection;

class JiraIssueService
{
    protected JiraService $client;

    public function __construct(JiraService $jiraService)
    {
        $this->client = $jiraService;
    }

    public function fetchIssues(int $sprintId): array
    {
        $response = $this->client->get("rest/agile/1.0/sprint/{$sprintId}/issue",[
            'fields' => 'summary,timetracking'
        ]);

        //dd($response);

        return $response['issues'] ?? [];
    }

    public function syncIssues(int $sprintId, int $jiraSprintId): Collection
    {
        $issues = collect($this->fetchIssues($jiraSprintId));

        return $issues->map(function ($issueData) use ($sprintId) {

            $fields = $issueData['fields'] ?? [];
            $timetracking = $fields['timetracking']['originalEstimateSeconds'] ?? 0;
            $timeSpent = $fields['timetracking']['timeSpentSeconds'] ?? 0;

            return Issue::updateOrCreate(
                ['jira_id' => $issueData['id']],
                [
                    'sprint_id' => $sprintId,
                    'key' => $issueData['key'],
                    'summary' => $fields['summary'] ?? 'Untitled',
                    'time_estimate' => $timetracking,
                    'time_spent' => $timeSpent,
                ]
            );
        });
    }
}
