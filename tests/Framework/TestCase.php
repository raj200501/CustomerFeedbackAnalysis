<?php

namespace Tests\Framework;

class TestCase
{
    private array $assertions = [];

    public function assertTrue(bool $condition, string $message = 'Expected condition to be true.'): void
    {
        if (!$condition) {
            throw new \RuntimeException($message);
        }
        $this->assertions[] = true;
    }

    public function assertFalse(bool $condition, string $message = 'Expected condition to be false.'): void
    {
        if ($condition) {
            throw new \RuntimeException($message);
        }
        $this->assertions[] = true;
    }

    public function assertSame($expected, $actual, string $message = ''): void
    {
        if ($expected !== $actual) {
            $message = $message !== '' ? $message : sprintf('Expected %s, got %s.', var_export($expected, true), var_export($actual, true));
            throw new \RuntimeException($message);
        }
        $this->assertions[] = true;
    }

    public function assertNotEmpty($actual, string $message = 'Expected value to be non-empty.'): void
    {
        if (empty($actual)) {
            throw new \RuntimeException($message);
        }
        $this->assertions[] = true;
    }

    public function assertCount(int $expected, array $actual, string $message = ''): void
    {
        $count = count($actual);
        if ($count !== $expected) {
            $message = $message !== '' ? $message : sprintf('Expected count %d, got %d.', $expected, $count);
            throw new \RuntimeException($message);
        }
        $this->assertions[] = true;
    }

    public function assertions(): int
    {
        return count($this->assertions);
    }
}
