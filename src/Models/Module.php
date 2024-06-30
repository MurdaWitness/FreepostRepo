<?php

namespace App\Models;

class Module
{
    public function __construct(
        private int $id,
        private string $name,
        private string $briefDescription,
        private string $description,
        private int $downloadsCount,
        private string $status,
        private int $userId,
        private string $createdAt,
        private string $updatedAt,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function briefDescription(): string
    {
        return $this->briefDescription;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function downloadsCount(): int
    {
        return $this->downloadsCount;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function updatedAt(): string
    {
        return $this->updatedAt;
    }
}
