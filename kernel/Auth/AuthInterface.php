<?php

namespace App\Kernel\Auth;

interface AuthInterface
{
    public function attempt(string $email, string $password): bool;

    public function logout(): void;

    public function check(): bool;

    public function user(): ?User;

    public function findUser(int $id): ?User;

    public function id(): ?int;

    public function table(): string;

    public function username(): string;

    public function email(): string;

    public function password(): string;

    public function sessionField(): string;
}