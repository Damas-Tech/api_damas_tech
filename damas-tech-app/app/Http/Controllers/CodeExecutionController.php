<?php

namespace App\Http\Controllers;

use App\Services\CodeExecutionService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CodeExecutionController extends Controller
{
    use ApiResponse;

    protected $executionService;

    public function __construct(CodeExecutionService $executionService)
    {
        $this->executionService = $executionService;
    }

    public function runtimes()
    {
        $runtimes = $this->executionService->getRuntimes();
        return $this->success($runtimes);
    }

    public function execute(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
            'code' => 'required|string',
            'version' => 'nullable|string',
            'stdin' => 'nullable|string',
        ]);

        $language = $request->input('language');
        $code = $request->input('code');
        $version = $request->input('version', '*');
        $stdin = $request->input('stdin', '');

        if (strlen($code) > 10000) {
            return $this->error('messages.error.validation', 422, ['code' => 'Code too long']);
        }

        $result = $this->executionService->executeCode($language, $code, $version, $stdin);

        return $this->success($result);
    }
}
