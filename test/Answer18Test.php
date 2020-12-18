<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer18;

class Answer18Test extends BaseTest
{
    /**
     * @var Answer18
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer18($this->logger);
    }

    /**
     * @dataProvider dataForEvaluate
     */
    public function testEvaluate($expression, $result)
    {
        $this->assertEquals($result, $this->answer->evaluate($expression));
    }

    public function dataForEvaluate()
    {
        return [
            ['1 + 2 * 3 + 4 * 5 + 6', 71],
            ['1 + (2 * 3) + (4 * (5 + 6))', 51],
            ['2 * 3 + (4 * 5)', 26],
            ['5 + (8 * 3 + 9 + 3 * 4 * 3)', 437],
            ['5 * 9 * (7 * 3 * 3 + 9 * 3 + (8 + 6 * 4))', 12240],
            ['((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2', 13632],
        ];
    }

    /**
     * @dataProvider dataForEvaluateWithPrecedence
     */
    public function testEvaluateWithPrecedence($expression, $result)
    {
        $this->assertEquals($result, $this->answer->evaluate($expression, true));
    }

    public function dataForEvaluateWithPrecedence()
    {
        return [
            ['1 + (2 * 3) + (4 * (5 + 6))', 51],
            ['2 * 3 + (4 * 5)', 46],
            ['5 + (8 * 3 + 9 + 3 * 4 * 3)', 1445],
            ['5 * 9 * (7 * 3 * 3 + 9 * 3 + (8 + 6 * 4))', 669060],
            ['((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2', 23340],
        ];
    }
}