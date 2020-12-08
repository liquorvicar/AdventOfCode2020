<?php

namespace AdventOfCode\Test\App\Handheld;

use AdventOfCode\App\Handheld\JumpCommand;
use AdventOfCode\App\Handheld\Registry;
use PHPUnit\Framework\TestCase;

class JumpCommandTest extends TestCase
{

    public function testJumpZeroJumpsToSelf()
    {
        $command = new JumpCommand(0);
        $registry = new Registry(17, 23);

        $registry = $command->execute($registry);

        $this->assertEquals(17, $registry->getPosition());
    }

    public function testJumpForward()
    {
        $command = new JumpCommand(5);
        $registry = new Registry(17, 23);

        $registry = $command->execute($registry);

        $this->assertEquals(22, $registry->getPosition());
    }

    public function testJumpBack()
    {
        $command = new JumpCommand(-5);
        $registry = new Registry(17, 23);

        $registry = $command->execute($registry);

        $this->assertEquals(12, $registry->getPosition());
    }
}