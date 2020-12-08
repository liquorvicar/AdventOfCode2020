<?php

namespace AdventOfCode\App\Handheld;

class AccumulateCommand implements Command
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
        return $registry->jump(1, $registry->getPosition())->add($this->delta);
    }

    public function repair(): Command
    {
        return $this;
    }
}