<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ModuleMaterialResource;
use App\Services\ModuleMaterialService;
use App\Support\ErrorMessages;
use Illuminate\Http\Request;

class ModuleMaterialController extends Controller
{
    protected $service;

    public function __construct(ModuleMaterialService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,pdf,doc,ppt,link',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,mov,avi',
            'external_link' => 'nullable|url',
        ]);

        try {
            $material = $this->service->create($data);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => ErrorMessages::get('generic.unexpected_error'),
            ], 500);
        }

        return (new ModuleMaterialResource($material))
            ->response()
            ->setStatusCode(201);
    }

    public function index($moduleId)
    {
        $materials = $this->service->getByModule($moduleId);

        return ModuleMaterialResource::collection($materials);
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => ErrorMessages::get('materials.not_found'),
            ], 404);
        }

        return response()->json(['message' => 'Material removido com sucesso']);
    }
}
