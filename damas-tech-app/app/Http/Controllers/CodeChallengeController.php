<?php

namespace App\Http\Controllers;

use App\Models\CodeChallenge;
use App\Models\UserChallengeProgress;
use App\Services\CodeExecutionService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CodeChallengeController extends Controller
{
    use ApiResponse;

    protected $executionService;

    public function __construct(CodeExecutionService $executionService)
    {
        $this->executionService = $executionService;
    }

    public function index(Request $request)
    {
        $query = CodeChallenge::query();
        if ($request->has('module_id')) {
            $query->where('module_id', $request->module_id);
        }

        $challenges = $query->with([
            'progress' => function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            }
        ])->get();

        return $this->success($challenges);
    }

    public function show($id)
    {
        $challenge = CodeChallenge::findOrFail($id);
        return $this->success($challenge);
    }
    public function check(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:10000',
        ]);

        $challenge = CodeChallenge::findOrFail($id);
        $userCode = $request->code;

        $language = $request->input('language', $challenge->language);
        if ($language === 'any')
            $language = 'python';

        $result = $this->executionService->executeCode($language, $userCode);

        $actualOutput = trim($result['run']['stdout'] ?? '');
        $expectedOutput = trim($challenge->expected_output);

        $passed = $actualOutput === $expectedOutput;
        $status = $passed ? 'completed' : 'failed';

        $progress = UserChallengeProgress::updateOrCreate(
            ['user_id' => $request->user()->id, 'challenge_id' => $id],
            [
                'status' => $status,
                'submitted_code' => $userCode,
            ]
        );
        $progress->increment('attempts');

        $responseData = [
            'passed' => $passed,
            'status' => $status,
            'actual_output' => $actualOutput,
            'expected_output' => $expectedOutput,
            'diff' => $passed ? null : 'Outputs do not match',
            'stderr' => $result['run']['stderr'] ?? null,
        ];

        return $this->success($responseData);
    }
}
