<?php

namespace Tests\Framework;

class TestRunner
{
    private array $results = [];

    public function run(array $testClasses): int
    {
        $totalAssertions = 0;
        $failures = 0;

        foreach ($testClasses as $class) {
            $instance = new $class();
            $methods = array_filter(get_class_methods($instance), fn($method) => str_starts_with($method, 'test'));

            foreach ($methods as $method) {
                try {
                    $instance->$method();
                    $assertions = method_exists($instance, 'assertions') ? $instance->assertions() : 0;
                    $totalAssertions += $assertions;
                    $this->results[] = ['class' => $class, 'method' => $method, 'status' => 'passed'];
                } catch (\Throwable $exception) {
                    $failures++;
                    $this->results[] = [
                        'class' => $class,
                        'method' => $method,
                        'status' => 'failed',
                        'message' => $exception->getMessage(),
                    ];
                }
            }
        }

        $this->report($totalAssertions, $failures);

        return $failures === 0 ? 0 : 1;
    }

    private function report(int $totalAssertions, int $failures): void
    {
        echo "\nTest Results\n";
        echo str_repeat('-', 40) . "\n";

        foreach ($this->results as $result) {
            $status = strtoupper($result['status']);
            echo sprintf('%s::%s - %s', $result['class'], $result['method'], $status);
            if ($result['status'] === 'failed') {
                echo ' (' . $result['message'] . ')';
            }
            echo "\n";
        }

        echo str_repeat('-', 40) . "\n";
        echo sprintf('Assertions: %d | Failures: %d\n', $totalAssertions, $failures);
    }
}
