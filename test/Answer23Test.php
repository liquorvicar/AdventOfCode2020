<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer23;

class Answer23Test extends BaseTest
{
    /**
     * @var Answer23
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer23($this->logger);
    }

    /**
     * @dataProvider dataForMakeMoves
     */
    public function testMakeMoves($input, $numMoves, $expected)
    {
        $cups = $this->answer->makeMoves($input, $numMoves);
        $next = $cups[1]['next'];
        $output = '1';
        while ($next !== 1) {
            $output.= (string)$next;
            $next = $cups[$next]['next'];
        }
        $this->assertEquals($expected, $output);
    }

    public function dataForMakeMoves()
    {
        return [
            ['389125467', 1, '154673289'],
            ['389125467', 2, '132546789'],
            ['389125467', 3, '134672589'],
            ['389125467', 4, '132584679'],
            ['389125467', 5, '136792584'],
            ['389125467', 6, '193672584'],
            ['389125467', 7, '192583674'],
            ['389125467', 8, '158392674'],
            ['389125467', 9, '183926574'],
            ['389125467', 10, '192658374'],
        ];
    }

    public function testOne()
    {
        $this->assertEquals('67384529', $this->answer->one(['389125467']));
    }

    public function testTwo()
    {
        $this->assertEquals('67384529', $this->answer->two(['389125467']));
    }
}