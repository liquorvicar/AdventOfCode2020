<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer01;

class Answer01Test extends BaseTest
{
    /**
     * @var Answer01
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer01($this->logger);
    }

    public function testPartOne()
    {
        $this->assertEquals(514579, $this->answer->one(['1721', '979', '366', '299', '675', '1456',]));
    }

    public function testPartTwo()
    {
        $this->assertEquals(241861950, $this->answer->two(['1721', '979', '366', '299', '675', '1456',]));
    }
}