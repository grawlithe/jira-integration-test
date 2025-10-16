<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\Jira\JiraService;
use App\Services\Jira\JiraBoardService;
use App\Services\Jira\JiraSprintService;
use App\Services\Jira\JiraIssueService;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    public function syncAll(Request $request)
    {
        $client = new JiraService();
        $boardService = new JiraBoardService($client);
        $sprintService = new JiraSprintService($client);
        $issueService = new JiraIssueService($client);

        $projects = Project::all();

        foreach ($projects as $project) {
            $boards = $boardService->getBoardsForProject($project->key);

            Log::info("Syncing project {$project->key} with " . count($boards) . " boards.");

            foreach ($boards as $board) {

                if($board['type'] !== 'scrum'){
                    Log::info("  Skipping non-scrum board {$board['name']} ({$board['id']}) of type {$board['type']}.");
                }

                $activeSprints = $sprintService->syncActiveSprints($project->id,$board['id']);

                Log::info("  Board {$board['name']} ({$board['id']}) has " . count($activeSprints) . " active sprints.");

                foreach ($activeSprints as $sprintData) {

                    $issueService->syncIssues($sprintData->id, $sprintData->jira_id);

                    Log::info("    Synced issues for sprint {$sprintData->name} ({$sprintData->id}).");
                }
            }
        }


        return response()->json(['message' => 'All data synced successfully']);
    }
}
