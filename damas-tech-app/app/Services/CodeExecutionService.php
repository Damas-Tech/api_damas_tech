<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CodeExecutionService
{
    protected string $baseUrl = 'https://emkc.org/api/v2/piston';

    /**
     * Get available runtimes/languages from Piston.
     */
    public function getRuntimes()
    {
        try {
            $response = Http::get("{$this->baseUrl}/runtimes");
            if ($response->successful()) {
                return $response->json();
            }
            Log::error('Failed to fetch runtimes from Piston', ['status' => $response->status(), 'body' => $response->body()]);
            return [];
        } catch (\Exception $e) {
            Log::error('Exception fetching runtimes', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Execute code using Piston API.
     *
     * @param string $language The programming language (e.g., 'python', 'javascript')
     * @param string $version The version of the language (optional, Piston usually handles latest/default)
     * @param string $code The source code to execute
     * @param string $stdin Standard input (optional)
     * @return array Result containing stdout, stderr, etc.
     */
    public function executeCode(string $language, string $code, string $version = '*', string $stdin = '')
    {
        try {
            $payload = [
                'language' => $language,
                'version' => $version,
                'files' => [
                    [
                        'content' => $code,
                    ],
                ],
                'stdin' => $stdin,
            ];

            $response = Http::post("{$this->baseUrl}/execute", $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to execute code on Piston', ['status' => $response->status(), 'body' => $response->body()]);

            return [
                'run' => [
                    'stdout' => '',
                    'stderr' => 'Execution failed: External API error',
                    'code' => $response->status(),
                ],
            ];

        } catch (\Exception $e) {
            Log::error('Exception executing code', ['error' => $e->getMessage()]);
            return [
                'run' => [
                    'stdout' => '',
                    'stderr' => 'Execution failed: Server error',
                    'code' => 500,
                ],
            ];
        }
    }
}
