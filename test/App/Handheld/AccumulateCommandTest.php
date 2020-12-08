<?php

namespace AdventOfCode\Test\App\Handheld;

use AdventOfCode\App\Handheld\AccumulateCommand;
use AdventOfCode\App\Handheld\Registry;
use PHPUnit\Framework\TestCase;

class AccumulateCommandTest extends TestCase
{

    public function testWithZeroNoChange()
    {
        $command = new AccumulateCommand(0);
        $registry = new Registry(17, 23);

        $registry = $command->execute($registry);

        $this->assertEquals(18, $registry->getPosition());
        $this->assertEquals(23, $registry->getAccumulator());
    }

    public function testAddsPositiveDelta()
    {
        $command = new AccumulateCommand(3);
        $registry = new Registry(17, 23);

        $registry = $command->execute($registry);

        $this->assertEquals(26, $registry->getAccumulator());
    }

    public function testSubtractsNegativeDelta()
    {
        $command = new AccumulateCommand(-3);
        $registry = new Registry(17, 23);

        $registry = $command->execute($registry);

        $this->assertEquals(20, $registry->getAccumulator());
    }
}