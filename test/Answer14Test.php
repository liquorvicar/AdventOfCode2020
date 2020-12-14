<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer14;
use AdventOfCode\App\PortDocker\Bitmask;

class Answer14Test extends BaseTest
{
    /**
     * @var Answer14
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer14($this->logger);
    }

    public function testOne()
    {
        $program = [
            'mask = XXXXXXXXXXXXXXXXXXXXXXXXXXXXX1XXXX0X',
            'mem[8] = 11',
            'mem[7] = 101',
            'mem[8] = 0',
        ];

        $this->assertEquals(165, $this->answer->one($program));
    }

    /**
     * @dataProvider dataForFindAffectedAddresses
     */
    public function testFindAffectedAddresses($value, $mask, $affectedAddresses)
    {
        $this->assertEquals($affectedAddresses, $this->answer->findAffectedAddresses($value, $mask));
    }

    public function dataForFindAffectedAddresses()
    {
        return [
            [42, '000000000000000000000000000000X1001X', [26, 27, 58, 59]],
            [26, '00000000000000000000000000000000X0XX', [16, 17, 18, 19, 24, 25, 26, 27]],
        ];
    }
}