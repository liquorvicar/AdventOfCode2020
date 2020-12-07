<?php

namespace AdventOfCode\App;

class BagRule
{

    /**
     * @var int
     */
    private $count;
    /**
     * @var string
     */
    private $colour;

    public function __construct(int $count, string $colour)
    {
        $this->count = $count;
        $this->colour = $colour;
    }

    public function getColour(): string
    {
        return $this->colour;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}