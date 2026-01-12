<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ModuleMaterial;

class ModuleMaterialRepository
{
    public function create(array $data): ModuleMaterial
    {
        return ModuleMaterial::create($data);
    }

    public function findByModule(int $moduleId)
    {
        return ModuleMaterial::where('module_id', $moduleId)->get();
    }

    public function delete(int $id): bool
    {
        return ModuleMaterial::where('id', $id)->delete();
    }
}
