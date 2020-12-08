<?php

namespace AdventOfCode;

class Answer08 extends Base
{

    public function one(array $input)
    {
        $program = $this->trim($input);

        $result = $this->runProgram($program);

        return $result['acc'];
    }

    public function two(array $input)
    {
        $program = $this->trim($input);
        $terminated = false;
        $acc = 0;

        foreach ($program as $lineNum => $line) {
            $newProgram = $program;
            $command = substr($line, 0, 3);
            switch ($command) {
                case 'acc':
                    break;
                case 'jmp':
                    $newProgram[$lineNum] = str_replace('jmp', 'nop', $line);
                    $result = $this->runProgram($newProgram);
                    $terminated = $result['terminated'];
                    $acc = $result['acc'];
                    break;
                case 'nop':
                    $newProgram[$lineNum] = str_replace('nop', 'jmp', $line);
                    $result = $this->runProgram($newProgram);
                    $terminated = $result['terminated'];
                    $acc = $result['acc'];
                    break;
            }
            if ($terminated) {
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

