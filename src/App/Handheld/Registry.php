<?php

namespace AdventOfCode\App\Handheld;

class Registry
{
    /**
     * @var int
     */
    private $position;
    /**
     * @var int
     */
    private $accumulator;
    /**
     * @var array
     */
    private $executed;
    /**
     * @var bool
     */
    private $terminated;

    public function __construct(int $position, int $accumulator, array $executed = [], $terminated = false)
    {
        $this->position = $position;
        $this->accumulator = $accumulator;
        $this->executed = $executed;
        $this->terminated = $terminated;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getAccumulator(): int
    {
        return $this->accumulator;
    }

    public function jump(int $distance, int $position): self
    {
        $executed = $this->executed;
        $executed[$position] = true;
        return new Registry($this->getPosition() + $distance, $this->getAccumulator(), $executed);
    }

    public function add(int $delta, ?int $position = null): self
    {
        $executed = $this->executed;
        if ($position) {
           $executed[$position] = true;
        }
        return new Registry($this->getPosition(), $this->getAccumulator() + $delta, $executed);
    }

    public function isInLoop(): bool
    {
        return isset($this->executed[$this->position]);
    }

    public function terminate(): self
    {
        return new Registry($this->position, $this->accumulator, $this->executed, true);
    }

    public function isTerminated(): bool
    {
        return $this->terminated;
    }
}