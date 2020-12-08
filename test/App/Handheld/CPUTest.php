<?php

namespace AdventOfCode\Test\App\Handheld;

use AdventOfCode\App\Handheld\CommandFactory;
use AdventOfCode\App\Handheld\CPU;
use AdventOfCode\App\Handheld\Program;
use AdventOfCode\App\Handheld\Registry;
use PHPUnit\Framework\TestCase;

class CPUTest extends TestCase
{

    public function testBreaksOnLoop()
    {
        $program = $this->loadProgram(['jmp 0']);
        $cpu = new CPU();
        $registry = $cpu->run($program, new Registry(0, 7));

        $this->assertEquals(7, $registry->getAccumulator());
    }

    public function testRunsCommands()
    {
        $program = $this->loadProgram(['acc 3', 'jmp 0']);
        $cpu = new CPU();
        $registry = $cpu->run($program, new Registry(0, 7));

        $this->assertEquals(10, $registry->getAccumulator());
    }

    public function testRunsExampleProgram()
    {
        $program = $this->loadProgram([
            'nop +0',
            'acc +1',
            'jmp +4',
            'acc +3',
            'jmp -3',
            'acc -99',
            'acc +1',
            'jmp -4',
            'acc +6',
        ]);
        $cpu = new CPU();
        $registry = $cpu->run($program, new Registry(0, 0));

        $this->assertEquals(5, $registry->getAccumulator());
    }

    private function loadProgram(array $commands): Program
    {
        $commands = array_map(function ($command) {
            return CommandFactory::create($command);
        }, $commands);

        return new Program($commands);
    }
}