<?php

namespace App\Support;

class Dotenv
{
    private string $path;
    private bool $loaded = false;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function load(): void
    {
        if ($this->loaded || !is_file($this->path)) {
            return;
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$name, $value] = $this->parseLine($line);
            if ($name === null) {
                continue;
            }

            if (getenv($name) === false) {
                putenv($name . '=' . $value);
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }

        $this->loaded = true;
    }

    private function parseLine(string $line): array
    {
        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            return [null, null];
        }

        $name = trim($parts[0]);
        $value = trim($parts[1]);

        if ($name === '') {
            return [null, null];
        }

        $value = $this->stripQuotes($value);

        return [$name, $value];
    }

    private function stripQuotes(string $value): string
    {
        if ((str_starts_with($value, '"') && str_ends_with($value, '"'))
            || (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}
