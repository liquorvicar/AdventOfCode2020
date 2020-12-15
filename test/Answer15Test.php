<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer15;

class Answer15Test extends BaseTest
{
    /**
     * @var Answer15
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer15($this->logger);
    }

    /**
     * @dataProvider dataForNextNumberSpoken
     */
    public function testNextNumberSpoken($numbers, $lastNumberSpoken, $countSpoken, $expected)
    {
        $this->assertEquals($expected, $this->answer->nextNumberSpoken($lastNumberSpoken, $countSpoken, $numbers));
    }

    public function dataForNextNumberSpoken()
    {
        return [
            [[0 => 0, 3 => 1], 6, 3, 0],
            [[0 => 0, 3 => 1, 6 => 2,], 0, 4, 3],
            [[0 => 3, 3 => 1, 6 => 2,], 3, 5, 3],
            [[0 => 3, 3 => 4, 6 => 2,], 3, 6, 1],
            [[0 => 3, 3 => 5, 6 => 2,], 1, 7, 0],
        ];
    }

    public function testFindNextAfterX()
    {
        $this->assertEquals(0, $this->answer->findXNumberSpoken([0, 3, 6], 10));
    }

    /**
     * @dataProvider dataForOne
     */
    public function testOne($startingNumbers, $expected)
    {
        $this->assertEquals($expected, $this->answer->one($startingNumbers));
    }

    public function dataForOne()
    {
        return [
            [[0, 3, 6], 436],
            [[1, 3, 2], 1],
            [[2, 1, 3], 10],
        ];
    }
}