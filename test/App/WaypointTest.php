<?php

namespace AdventOfCode\Test\App;

use AdventOfCode\App\Waypoint;
use PHPUnit\Framework\TestCase;

class WaypointTest extends TestCase
{

    /**
     * @dataProvider dataForLeft
     */
    public function testMoveLeft($north, $east, $degrees, $expectedNorth, $expectedEast)
    {
        $waypoint = new Waypoint($north, $east);
        $waypoint = $waypoint->left($degrees);
        $this->assertEquals($expectedNorth, $waypoint->northing());
        $this->assertEquals($expectedEast, $waypoint->easting());
    }

    public function dataForLeft()
    {
        return [
            [-10, 4, 90, -4, -10],
            [-4, -10, 90, 10, -4],
            [10, -4, 90, 4, 10],
            [4, 10, 90, -10, 4],
            [-10, 4, 180, 10, -4],
            [-10, 4, 270, 4, 10],
        ];
    }

    /**
     * @dataProvider dataForRight
     */
    public function testMoveRight($north, $east, $degrees, $expectedNorth, $expectedEast)
    {
        $waypoint = new Waypoint($north, $east);
        $waypoint = $waypoint->right($degrees);
        $this->assertEquals($expectedNorth, $waypoint->northing());
        $this->assertEquals($expectedEast, $waypoint->easting());
    }

    public function dataForRight()
    {
        return [
            [-10, 4, 90, 4, 10],
            [4, 10, 90, 10, -4],
            [10, -4, 90, -4, -10],
            [-4, -10, 90, -10, 4],
            [-10, 4, 180, 10, -4],
            [-10, 4, 270, -4, -10],
        ];
    }
}