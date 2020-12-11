<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer10;

class Answer10Test extends BaseTest
{
    /**
     * @var Answer10
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer10($this->logger);
    }

    public function testOne()
    {
        $input = [
            16,
            10,
            15,
            5,
            1,
            11,
            7,
            19,
            6,
            12,
            4,
        ];
        $this->assertEquals(35, $this->answer->one($input));
    }

    /**
     * @dataProvider dataForTwo
     */
    public function testTwo($input, $chains)
    {
        $this->assertEquals($chains, $this->answer->two($input));
    }

    public function dataForTwo()
    {
        return [
            [[16, 10, 15, 5, 1, 11, 7, 19, 6, 12, 4], 8],
            [[28, 33, 18, 42, 31, 14, 46, 20, 48, 47, 24, 23, 49, 45, 19, 38, 39, 11, 1, 32, 25, 35, 8, 17, 7, 9, 4, 2, 34, 10, 3], 19208],
        ];
    }
}






























