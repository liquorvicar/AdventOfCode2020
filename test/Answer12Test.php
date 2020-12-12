<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer12;
use AdventOfCode\App\Ferry;
use AdventOfCode\App\Waypoint;

class Answer12Test extends BaseTest
{
    /**
     * @var Answer12
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer12($this->logger);
    }

    public function testOne()
    {
        $input = [
            'F10',
            'N3',
            'F7',
            'R90',
            'F11',
        ];
        $this->assertEquals(25, $this->answer->one($input));
    }

    public function testTwo()
    {
        $input = [
            'F10',
            'N3',
            'F7',
            'R90',
            'F11',
        ];
        $this->assertEquals(286, $this->answer->two($input));
    }

    public function testTwoRealInput()
    {
        $ferry = new Ferry();
        $waypoint = new Waypoint(-1, 10);
        $waypoint = $waypoint->left(90)
            ->north(5)
            ->left(180)
            ->left(180)
            ->south(4)
        ;
        $ferry = $ferry->forwardToWaypoint(21, $waypoint);
        $waypoint = $waypoint->west(4)
            ->south(1)
            ->right(270)
        ;
        $this->assertEquals(-10, $waypoint->easting());
        $this->assertEquals(5, $waypoint->northing());
        $this->assertEquals(-21, $ferry->easting());
        $this->assertEquals(-231, $ferry->northing());
    }
}