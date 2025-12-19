<?php

namespace App\Services;

use App\Models\Module;
use App\Models\ModuleMaterial;
use App\Models\ModuleVideo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CourseContentService
{
    public function addMaterial($moduleId, $fileOrLink, $type)
    {
        if ($fileOrLink instanceof UploadedFile) {
            $path = $fileOrLink->store('modules/' . $moduleId, 'public');
        } else {
            $path = $fileOrLink;
        }

        return ModuleMaterial::create([
            'module_id' => $moduleId,
            'type' => $type,
            'url' => $path,
        ]);
    }

    public function addVideo($moduleId, $title, $url, $duration)
    {
        return ModuleVideo::create([
            'module_id' => $moduleId,
            'title' => $title,
            'url' => $url,
            'duration' => $duration,
        ]);
    }

    public function listMaterials($moduleId)
    {
        return ModuleMaterial::where('module_id', $moduleId)->get();
    }

    public function listVideos($moduleId)
    {
        return ModuleVideo::where('module_id', $moduleId)->get();
    }
}
