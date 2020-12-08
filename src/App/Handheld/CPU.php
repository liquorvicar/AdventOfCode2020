<?php

namespace AdventOfCode\App\Handheld;

class CPU
{

    public function run(Program $program, Registry $registry): Registry
    {
        $terminated = false;
        while (!$terminated) {
            $registry = $program->execute($registry);

            $terminated = $registry->isTerminated() || $registry->isInLoop();
        }

        return $registry;
    }
}