<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\ModuleMaterialRepository;

class ModuleMaterialService
{
    protected ModuleMaterialRepository $repository;

    public function __construct(ModuleMaterialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        if (isset($data['file'])) {
            $path = $data['file']->store('materials', 'public');
            $data['file_path'] = $path;
        }

        unset($data['file']);

        return $this->repository->create($data);
    }

    public function getByModule(int $moduleId)
    {
        return $this->repository->findByModule($moduleId);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
