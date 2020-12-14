<?php

namespace AdventOfCode\Test\App\PortDocker;

use AdventOfCode\App\PortDocker\Bitmask;
use AdventOfCode\App\PortDocker\Value;
use PHPUnit\Framework\TestCase;

class ValueTest extends TestCase
{

    /**
     * @dataProvider dataForApplyBitmask
     */
    public function testApplyBitmask($initial, $expected)
    {
        $mask = new Bitmask('XXXXXXXXXXXXXXXXXXXXXXXXXXXXX1XXXX0X');
        $value = new Value($initial);
        $value = $value->apply($mask);

        $this->assertEquals($expected, $value->decimal());
    }

    public function dataForApplyBitmask()
    {
        return [
            [11, 73],
            [101, 101],
            [0, 64],
        ];
    }

}