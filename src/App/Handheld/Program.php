<?php

namespace AdventOfCode\App\Handheld;

class Program
{

    /**
     * @var Command[]
     */
    private $commands;

    public function __construct(array $commands)
    {
        $this->commands = $commands;
    }

    public function execute(Registry $registry)
    {
        $command = $this->commands[$registry->getPosition()] ?? null;
        if (!$command) {
            return $registry->terminate();
        }

        return $command->execute($registry);
    }
}
