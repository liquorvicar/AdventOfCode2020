<?php

namespace AdventOfCode\Test\App\Handheld;

use AdventOfCode\App\Handheld\NoopCommand;
use AdventOfCode\App\Handheld\Registry;
use PHPUnit\Framework\TestCase;

class NoopCommandTest extends TestCase
{

    public function testAdvancesRegistry()
    {
        $command = new NoopCommand(7);
        $registry = new Registry(17, 23);

        $registry = $command->execute($registry);

        $this->assertEquals(18, $registry->getPosition());
    }
}