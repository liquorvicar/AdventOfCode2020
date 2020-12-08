<?php

namespace AdventOfCode\App\Handheld;

class CommandFactory
{

    public static function create(string $command): Command
    {
        switch (substr($command, 0, 3)) {
            case 'nop':
                return new NoopCommand(0);
            case 'acc':
                return new AccumulateCommand((int)substr($command, 4));
            case 'jmp':
                return new JumpCommand((int)substr($command, 4));
        }

        throw new \Exception('Cannot create command ' . $command);
    }
}