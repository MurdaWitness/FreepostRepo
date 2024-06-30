<?php

namespace App\Services;

use App\Kernel\Config\ConfigInterface;
use App\Kernel\Database\DatabaseInterface;
use App\Models\File;

class FileService
{
    public function __construct(
        private DatabaseInterface $db,
        private ConfigInterface $config,
    ) {
    }

    public function create(int $moduleId, array $uploadedFiles)
    {
        foreach ($uploadedFiles as $uploadedFile) {
            $filePath = $uploadedFile->move("$moduleId", $uploadedFile->name());

            $this->db->insert('files', [
                'module_id' => $moduleId,
                'file_name' => $uploadedFile->name(),
                'file_path' => $filePath,
            ]);
        }
    }

    public function read(int $moduleId): ?array
    {
        $files = $this->db->get('files', ['module_id' => $moduleId]);

        if ($files) {
            $array = [];

            foreach ($files as $file) {
                $array[] = new File(
                    $file['id'],
                    $file['module_id'],
                    $file['file_name'],
                    $file['file_path']
                );
            }
            return $array;
        }

        return null;
    }

    public function update(int $moduleId, array $uploadedFiles)
    {
        foreach ($uploadedFiles as $uploadedFile) {
            $fileName = $uploadedFile->name();

            $filePath = $this->config->get('storage.path') . $moduleId . '/' . $fileName;

            if (file_exists($filePath)) {
                unlink($filePath);

                $uploadedFile->move("$moduleId", $uploadedFile->name());
            } else {
                $filePath = $uploadedFile->move("$moduleId", $uploadedFile->name());

                $this->db->insert('files', [
                    'module_id' => $moduleId,
                    'file_name' => $uploadedFile->name(),
                    'file_path' => $filePath,
                ]);
            }
        }
    }

    public function delete(string $folderName, array $files): void
    {
        foreach ($files as $file) {
            $file = new File(
                $file['id'],
                $file['module_id'],
                $file['file_name'],
                $file['file_path'],
            );

            $file->delete();
        }

        $folderPath = $this->config->get('storage.path') . '/' . $folderName;

        rmdir($folderPath);
    }

    public function download(string $moduleId): void
    {
        $directory = $this->config->get('storage.path') . '/' . $moduleId;
        $zipFile = $this->config->get('storage.path') . '/' . $moduleId . '.zip';

        $this->createZipFromDirectory($directory, $zipFile);

        if (file_exists($zipFile)) {
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($zipFile) . '"');
            header('Content-Length: ' . filesize($zipFile));

            readfile($zipFile);

            unlink($zipFile);
        }
    }

    private function createZipFromDirectory($directory, $zipFile)
    {
        $zip = new \ZipArchive();

        if ($zip->open($zipFile, \ZipArchive::CREATE)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($directory),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($directory) + 1);

                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
        }
    }
}