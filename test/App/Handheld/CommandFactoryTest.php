<?php

namespace AdventOfCode\Test\App\Handheld;

use AdventOfCode\App\Handheld\AccumulateCommand;
use AdventOfCode\App\Handheld\CommandFactory;
use AdventOfCode\App\Handheld\JumpCommand;
use AdventOfCode\App\Handheld\NoopCommand;
use PHPUnit\Framework\TestCase;

class CommandFactoryTest extends TestCase
{

    public function testCreatesNoop()
    {
        $command = CommandFactory::create('nop -10');

        $this->assertInstanceOf(NoopCommand::class, $command);
    }

    public function testCreatesAcc()
    {
        $command = CommandFactory::create('acc +7');

        $this->assertInstanceOf(AccumulateCommand::class, $command);
    }

    public function testCreatesJump()
    {
        $command = CommandFactory::create('jmp -5');

        $this->assertInstanceOf(JumpCommand::class, $command);
    }

    public function testThrowsExceptionForUnknownCommand()
    {
        $this->expectException(\Exception::class);

        CommandFactory::create('foo -5');
    }
}