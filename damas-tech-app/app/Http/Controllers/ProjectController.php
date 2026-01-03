<?php

namespace App\Http\Controllers;

use App\Models\ProjectSubmission;
use App\Models\ModuleMaterial;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ApiResponse;

    public function submit(Request $request, $materialId)
    {
        $request->validate(['submission_url' => 'required|url']);

        $material = ModuleMaterial::findOrFail($materialId);

        // Verification: Ensure material is of type 'project'
        // Since we changed type to string, we check string value
        if ($material->type !== 'project') {
            return $this->error('messages.error.unexpected', 400, ['error' => 'Material is not a project']);
        }

        $submission = ProjectSubmission::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'module_material_id' => $materialId,
            ],
            [
                'submission_url' => $request->submission_url,
                'status' => 'pending',
            ]
        );

        // TODO: Trigger notification to admins?

        return $this->success($submission, 'messages.success.saved');
    }

    public function index(Request $request)
    {
        $submissions = ProjectSubmission::where('user_id', $request->user()->id)
            ->with('material.module.course')
            ->latest()
            ->get();

        return $this->success($submissions);
    }
}
