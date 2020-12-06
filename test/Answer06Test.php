<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer06;

class Answer06Test extends BaseTest
{
    /**
     * @var Answer06
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer06($this->logger);
    }

    /**
     * @dataProvider dataForCountAnyYesQuestions
     */
    public function testCountAnyYesQuestions($group, $expectedYeses)
    {
        $yeses = $this->answer->countAnyYesQuestions($group);

        $this->assertEquals($expectedYeses, $yeses);
    }

    public function dataForCountAnyYesQuestions()
    {
        return [
            [['abcx', 'abcy', 'abcz',], 6],
            [['abc',], 3,],
            [['a', 'b', 'c',], 3, ],
            [['ab', 'ac',], 3, ],
            [['a', 'a', 'a', 'a',], 1, ],
            [['b',], 1],
        ];
    }

    public function testCountGroupsAnyYeses()
    {
        $input = [
            'abcx',
            'abcy',
            'abcz',
            '',
            'abc',
            '',
            'a',
            'b',
            'c',
            '',
            'ab',
            'ac',
            '',
            'a',
            'a',
            'a',
            'a',
            '',
            'b',
        ];

        $this->assertEquals(17, $this->answer->countGroupsAnyYeses($input));
    }

    /**
     * @dataProvider dataForCountAllYesQuestions
     */
    public function testCountAllYesQuestions($group, $expectedYeses)
    {
        $yeses = $this->answer->countAllYesQuestions($group);

        $this->assertEquals($expectedYeses, $yeses);
    }

    public function dataForCountAllYesQuestions()
    {
        return [
            [['abcx', 'abcy', 'abcz',], 3],
            [['abc',], 3,],
            [['a', 'b', 'c',], 0, ],
            [['ab', 'ac',], 1, ],
            [['a', 'a', 'a', 'a',], 1, ],
            [['b',], 1],
        ];
    }

    public function testCountGroupsAllYeses()
    {
        $input = [
            'abcx',
            'abcy',
            'abcz',
            '',
            'abc',
            '',
            'a',
            'b',
            'c',
            '',
            'ab',
            'ac',
            '',
            'a',
            'a',
            'a',
            'a',
            '',
            'b',
        ];

        $this->assertEquals(9, $this->answer->countGroupsAllYeses($input));
    }
}