<?php

namespace App\Models;

class File
{
    public function __construct(
        private int $id,
        private int $moduleId,
        private string $fileName,
        private string $filePath,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function moduleId(): int
    {
        return $this->moduleId;
    }

    public function fileName(): string
    {
        return $this->fileName;
    }

    public function filePath(): string
    {
        return $this->filePath;
    }

    public function delete()
    {
        if (file_exists($this->filePath())) {
            unlink($this->filePath());
        }

    }
}