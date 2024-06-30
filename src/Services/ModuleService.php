<?php

namespace App\Services;

use App\Kernel\Config\ConfigInterface;
use App\Kernel\Database\DatabaseInterface;
use App\Models\Module;

class ModuleService
{
    public function __construct(
        private DatabaseInterface $db,
        private ConfigInterface $config,
    ) {
    }

    public function all(): array
    {
        $modules = $this->db->get('modules');

        return array_map(function ($module) {
            return new Module(
                $module['id'],
                $module['name'],
                $module['brief_description'],
                $module['description'],
                $module['downloads_count'],
                $module['status'],
                $module['user_id'],
                $module['created_at'],
                $module['updated_at']
            );
        }, $modules);
    }

    public function store(string $name, string $briefDescription, string $description, int $downloadsCount, string $status, int $userId, array $uploadedFiles): false|int
    {
        $moduleId = $this->db->insert('modules', [
            'name' => $name,
            'brief_description' => $briefDescription,
            'description' => $description,
            'downloads_count' => $downloadsCount,
            'status' => $status,
            'user_id' => $userId,
        ]);

        if ($moduleId) {
            $fileService = new FileService($this->db, $this->config);
            $fileService->create($moduleId, $uploadedFiles);
        }

        return $moduleId;
    }

    public function findById(int $id): ?Module
    {
        $module = $this->db->first('modules', [
            'id' => $id,
        ]);

        if (!$module) {
            return null;
        }

        return new Module(
            $module['id'],
            $module['name'],
            $module['brief_description'],
            $module['description'],
            $module['downloads_count'],
            $module['status'],
            $module['user_id'],
            $module['created_at'],
            $module['updated_at']
        );
    }

    public function find(array $conditions): ?array
    {
        $modules = $this->db->get('modules', $conditions);

        if (!$modules) {
            return null;
        }

        return array_map(function ($module) {
            return new Module(
                $module['id'],
                $module['name'],
                $module['brief_description'],
                $module['description'],
                $module['downloads_count'],
                $module['status'],
                $module['user_id'],
                $module['created_at'],
                $module['updated_at']
            );
        }, $modules);

    }

    public function regExp(array $conditions): ?array
    {
        $modules = $this->db->regexp('modules', $conditions);

        if (!$modules) {
            return null;
        }

        return array_map(function ($module) {
            return new Module(
                $module['id'],
                $module['name'],
                $module['brief_description'],
                $module['description'],
                $module['downloads_count'],
                $module['status'],
                $module['user_id'],
                $module['created_at'],
                $module['updated_at']
            );
        }, $modules);

    }

    public function update(int $id, string $name, string $briefDescription, string $description, int $downloadsCount, string $status, int $userId, ?array $uploadedFiles): void
    {
        $data = [
            'name' => $name,
            'brief_description' => $briefDescription,
            'description' => $description,
            'downloads_count' => $downloadsCount,
            'status' => $status,
            'user_id' => $userId,
        ];

        $this->db->update('modules', $data, [
            'id' => $id,
        ]);

        if ($uploadedFiles) {
            $fileService = new FileService($this->db, $this->config);
            $fileService->update($id, $uploadedFiles);
        }
    }

    public function destroy(int $id): void
    {
        $files = $this->db->get('files', [
            'module_id' => $id,
        ]);

        if ($files) {
            $fileService = new FileService($this->db, $this->config);
            $fileService->delete($id, $files);
        }

        $this->db->delete('modules', [
            'id' => $id,
        ]);
    }

    public function download(int $id): void
    {
        $fileService = new FileService($this->db, $this->config);
        $fileService->download($id);

        $module = $this->findById($id);
        $this->update(
            $module->id(),
            $module->name(),
            $module->briefDescription(),
            $module->description(),
            $module->downloadsCount() + 1,
            $module->status(),
            $module->userId(),
            []
        );
    }
}
