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
    public function testMakeMoves($input, $numMoves, $output)
    {
        $cups = $this->answer->makeMoves($input, $numMoves);
        $this->assertEquals($output, implode($cups));
    }

    public function dataForMakeMoves()
    {
        return [
            ['389125467', 1, '289154673'],
            ['389125467', 2, '546789132'],
            ['389125467', 3, '891346725'],
            ['389125467', 4, '467913258'],
            ['389125467', 5, '136792584'],
            ['389125467', 6, '936725841'],
            ['389125467', 7, '258367419'],
            ['389125467', 8, '674158392'],
            ['389125467', 9, '574183926'],
            ['389125467', 10, '837419265'],
        ];
    }

    public function testOne()
    {
        $this->assertEquals('67384529', $this->answer->one(['389125467']));
    }
}