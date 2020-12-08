<?php

namespace AdventOfCode\App\Handheld;


class NoopCommand implements Command
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
        return $registry->jump(1, $registry->getPosition());
    }

    public function repair(): Command
    {
        return new JumpCommand($this->delta);
    }
}