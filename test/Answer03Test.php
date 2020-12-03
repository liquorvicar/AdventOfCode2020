<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer03;

class Answer03Test extends BaseTest
{
    /**
     * @var Answer03
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer03($this->logger);
    }

    public function testOne()
    {
        $grid = [
            '..##.......',
            '#...#...#..',
            '.#....#..#.',
            '..#.#...#.#',
            '.#...##..#.',
            '..#.##.....',
            '.#.#.#....#',
            '.#........#',
            '#.##...#...',
            '#...##....#',
            '.#..#...#.#',
        ];

        $this->assertEquals(7, $this->answer->one($grid));
    }
}