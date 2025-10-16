<?php

namespace App\Services\Jira;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JiraService
{

    protected string $baseUrl;
    protected string $email;
    protected string $api_token;

    public function __construct()
    {
        $this->baseUrl = config('services.atlassian.jira_url', 'https://your-domain.atlassian.net');
        $this->email = config('services.atlassian.email');
        $this->api_token = config('services.atlassian.api_token');
    }

    protected function request(string $method, string $endpoint, array $params = [])
    {
        $url = "{$this->baseUrl}/rest/api/3/{$endpoint}";

        $auth = base64_encode($this->email . ':' . $this->api_token);
        //dd($auth);
        $response = Http::withHeaders([
                'Authorization' => "Basic {$auth}",
                'Content-Type' => 'application/json',
            ])->$method($url, $params);

        if ($response->failed()) {
            dd([
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            // Log::error("Jira API request failed: {$response->body()}");
            // throw new \Exception("Jira API request failed with status {$response->status()}");
        }

        return $response->json();
    }

    public function get(string $endpoint, array $params = [])
    {
        return $this->request('get', $endpoint, $params);
    }
}
