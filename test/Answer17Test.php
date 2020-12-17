<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer17;

class Answer17Test extends BaseTest
{
    /**
     * @var Answer17
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer17($this->logger);
    }

    public function testOne()
    {
        $input = [
            '.#.',
            '..#',
            '###',
        ];
        $this->assertEquals(112, $this->answer->one($input));
    }

    public function testTwo()
    {
        $input = [
            '.#.',
            '..#',
            '###',
        ];
        $this->assertEquals(848, $this->answer->two($input));
    }
}