<?php

namespace AdventOfCode\App\PortDocker;

class Value
{
    /**
     * @var int
     */
    private $decimal;

    public function __construct(int $decimal)
    {
        $this->decimal = $decimal;
    }

    public function apply(Bitmask $mask): self
    {
        return new self($mask->apply($this->decimal));
    }

    public function decimal(): int
    {
        return $this->decimal;
    }
}