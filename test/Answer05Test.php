<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer05;

class Answer05Test extends BaseTest
{
    /**
     * @var Answer05
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer05($this->logger);
    }

    /**
     * @dataProvider dataForGetSeatCoords
     */
    public function testGetSeatCoords($boardingPass, $row, $column)
    {
        $coords = $this->answer->getSeatCoords($boardingPass);

        $this->assertEquals(['row' => $row, 'column' => $column], $coords);
    }

    public function dataForGetSeatCoords()
    {
        return [
            ['FBFBBFFRLR', 44, 5],
            ['BFFFBBFRRR', 70, 7,],
            ['FFFBBBFRRR', 14, 7,],
            ['BBFFBBFRLL', 102, 4],
        ];
    }

    /**
     * @dataProvider dataForGetSeatId
     */
    public function testGetSeatId($boardingPass, $id)
    {
        $result = $this->answer->getSeatId($boardingPass);

        $this->assertEquals($id, $result);
    }

    public function dataForGetSeatId()
    {
        return [
            ['FBFBBFFRLR', 357,],
            ['BFFFBBFRRR', 567,],
            ['FFFBBBFRRR', 119,],
            ['BBFFBBFRLL', 820,],
        ];

    }
}