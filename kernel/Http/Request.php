<?php

namespace App\Kernel\Http;

use App\Kernel\Upload\UploadedFile;
use App\Kernel\Upload\UploadedFileInterface;
use App\Kernel\Validator\ValidatorInterface;

class Request implements RequestInterface
{
    private ValidatorInterface $validator;

    public function __construct(
        public readonly array $get,
        public readonly array $post,
        public readonly array $server,
        public readonly array $files,
        public readonly array $cookies,
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
    }

    public function uri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function input(string $key, $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function files(string $key): ?array
    {
        if (!isset($this->files[$key])) {
            return null;
        }

        if (!is_array($this->files[$key]['name'])) {
            return [
                new UploadedFile(
                    $this->files[$key]['name'],
                    $this->files[$key]['type'],
                    $this->files[$key]['tmp_name'],
                    $this->files[$key]['error'],
                    $this->files[$key]['size']
                )
            ];
        }

        $uploadedFiles = [];
        $fileCount = count($this->files[$key]['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            $uploadedFiles[] = new UploadedFile(
                $this->files[$key]['name'][$i],
                $this->files[$key]['type'][$i],
                $this->files[$key]['tmp_name'][$i],
                $this->files[$key]['error'][$i],
                $this->files[$key]['size'][$i]
            );
        }

        return $uploadedFiles;
    }


    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    public function validate(array $rules): bool
    {
        $data = [];

        foreach ($rules as $field => $rule) {
            $data[$field] = $this->input($field);
        }

        return $this->validator->validate($data, $rules);
    }

    public function errors(): array
    {
        return $this->validator->errors();
    }
}