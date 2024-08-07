<?php

namespace App\Kernel\Upload;

use App\Kernel\Config\Config;

class UploadedFile implements UploadedFileInterface
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $tmpName,
        public readonly int $error,
        public readonly int $size,
    ) {
    }

    public function move(string $folderName, string $fileName = null): string|false
    {
        $config = new Config;

        $storagePath = $config->get('storage.path') . "/$folderName";

        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        $fileName = $fileName ?? $this->randomFileName();

        $filePath = "$storagePath/$fileName";

        if (move_uploaded_file($this->tmpName, $filePath)) {
            return $filePath;
        }

        return false;
    }

    private function randomFileName(): string
    {
        return md5(uniqid(rand(), true)) . ".{$this->getExtension()}";
    }

    public function getExtension(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    public function hasError(): bool
    {
        return $this->error !== UPLOAD_ERR_OK;
    }

    public function name(): string
    {
        return $this->name;
    }
}