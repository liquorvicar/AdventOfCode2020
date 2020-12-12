<?php

namespace AdventOfCode\Test\App;

use AdventOfCode\App\Ferry;
use PHPUnit\Framework\TestCase;

class CompassMovableTest extends TestCase
{
    public function testMoveNorth()
    {
        $ferry = new Ferry();
        $ferry = $ferry->north(10);
        $this->assertEquals($ferry->northing(), -10);
        $this->assertEquals($ferry->easting(), 0);
    }

    public function testMoveSouth()
    {
        $ferry = new Ferry();
        $ferry = $ferry->south(7);
        $this->assertEquals($ferry->northing(), 7);
        $this->assertEquals($ferry->easting(), 0);
    }

    public function testMoveEast()
    {
        $ferry = new Ferry();
        $ferry = $ferry->east(12);
        $this->assertEquals($ferry->northing(), 0);
        $this->assertEquals($ferry->easting(), 12);
    }

    public function testMoveWest()
    {
        $ferry = new Ferry();
        $ferry = $ferry->west(6);
        $this->assertEquals($ferry->northing(), 0);
        $this->assertEquals($ferry->easting(), -6);
    }


}