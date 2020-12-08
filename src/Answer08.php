<?php

namespace AdventOfCode;

use AdventOfCode\App\Handheld\CommandFactory;
use AdventOfCode\App\Handheld\CPU;
use AdventOfCode\App\Handheld\Program;
use AdventOfCode\App\Handheld\Registry;

class Answer08 extends Base
{

    public function one(array $input)
    {
        $commands = $this->trim($input);

        $commands = array_map(function ($command) {
            return CommandFactory::create($command);
        }, $commands);

        $program = new Program($commands);
        $cpu = new CPU();
        $registry = $cpu->run($program, new Registry(0, 0));

        return $registry->getAccumulator();
    }

    public function two(array $input)
    {
        $commands = $this->trim($input);
        $commands = array_map(function ($command) {
            return CommandFactory::create($command);
        }, $commands);
        $acc = 0;

        foreach ($commands as $lineNum => $command) {
            $newCommands = $commands;
            $newCommands[$lineNum] = $command->repair();
            $program = new Program($newCommands);
            $cpu = new CPU();
            $registry = $cpu->run($program, new Registry(0, 0));

            if ($registry->isTerminated()) {
                $acc = $registry->getAccumulator();
                break;
            }
        }

        return $acc;
    }

    protected function runProgram(array $program): array
    {
        $acc = 0;
        $current = 0;
        $executed = [];
        $terminated = false;
        while (!$terminated) {
            if (isset($executed[$current])) {
                break;
            } elseif ($current === count($program)) {
                $terminated = true;
                break;
            }
            $command = substr($program[$current], 0, 3);
            $operand = (int)trim(substr($program[$current], 4));
            $executed[$current] = true;
            switch ($command) {
                case 'acc':
                    $acc += $operand;
                    $current++;
                    break;
                case 'jmp':
                    $current += $operand;
                    break;
                case 'nop':
                    $current++;
                    break;
            }
        }

        return ['terminated' => $terminated, 'acc' => $acc];
    }
}

