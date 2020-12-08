<?php

namespace AdventOfCode\App\Handheld;

class JumpCommand implements Command
{
    /**
     * @var int
     */
    private $delta;

    public function __construct(int $delta)
    {
        $this->delta = $delta;
    }

    public function execute(Registry $registry): Registry
    {
        return $registry->jump($this->delta, $registry->getPosition());
    }

    public function repair(): Command
    {
        return new NoopCommand($this->delta);
    }
}