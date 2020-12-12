<?php

namespace AdventOfCode\Test\App;

use AdventOfCode\App\Ferry;
use AdventOfCode\App\Waypoint;
use AdventOfCode\Test\BaseTest;

class FerryTest extends BaseTest
{

    public function testTurnLeft()
    {
        $ferry = new Ferry('N');
        $ferry = $ferry->left(90);
        $this->assertEquals('W', $ferry->heading());
    }

    public function testTurnRight()
    {
        $ferry = new Ferry('E');
        $ferry = $ferry->right(180);
        $this->assertEquals('W', $ferry->heading());
    }

    public function testForwardWest()
    {
        $ferry = new Ferry('W');
        $ferry = $ferry->forward(6);
        $this->assertEquals($ferry->northing(), 0);
        $this->assertEquals($ferry->easting(), -6);
    }

    public function testForwardNorth()
    {
        $ferry = new Ferry('N');
        $ferry = $ferry->forward(10);
        $this->assertEquals($ferry->northing(), -10);
        $this->assertEquals($ferry->easting(), 0);
    }

    public function testForwardSouth()
    {
        $ferry = new Ferry('S');
        $ferry = $ferry->Forward(7);
        $this->assertEquals($ferry->northing(), 7);
        $this->assertEquals($ferry->easting(), 0);
    }

    public function testForwardEast()
    {
        $ferry = new Ferry('E');
        $ferry = $ferry->forward(12);
        $this->assertEquals($ferry->northing(), 0);
        $this->assertEquals($ferry->easting(), 12);
    }

    public function testForwardToWaypoint()
    {
        $ferry = new Ferry();
        $waypoint = new Waypoint(-1, 10);
        $ferry = $ferry->forwardToWaypoint(10, $waypoint);
        $this->assertEquals(-10, $ferry->northing());
        $this->assertEquals(100, $ferry->easting());
    }
}