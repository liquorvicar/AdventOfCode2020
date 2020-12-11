<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer11;

class Answer11Test extends BaseTest
{
    /**
     * @var Answer11
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer11($this->logger);
    }

    /**
     * @dataProvider dataForToggleSeat
     */
    public function testToggleSeat($row, $col, $expected)
    {
        $grid = [
            'L.LL.LL.LL',
            'L#LLLLL.LL',
            '##L.L..L..',
            '##LL.LL..L',
        ];
        $grid = $this->answer->parseGrid($grid);
        $toggled = $this->answer->toggleSeat($row, $col, $grid, 'countOccupiedAdjacent', 4);

        $this->assertEquals($expected, $toggled);
    }

    public function dataForToggleSeat()
    {
        return [
            'floor never toggles' => [0, 1, false],
            'empty with adjacent occupied does not toggle' => [0, 0, false],
            'empty with no adjacent occupied toggles' => [0, 3, true],
            'occupied with 4 or more occupied adjacent toggles' => [2, 0, true],
        ];
    }

    public function testOne()
    {
        $grid = [
            'L.LL.LL.LL',
            'LLLLLLL.LL',
            'L.L.L..L..',
            'LLLL.LL.LL',
            'L.LL.LL.LL',
            'L.LLLLL.LL',
            '..L.L.....',
            'LLLLLLLLLL',
            'L.LLLLLL.L',
            'L.LLLLL.LL',
        ];

        $this->assertEquals(37, $this->answer->one($grid));
    }

    public function testTwo()
    {
        $grid = [
            'L.LL.LL.LL',
            'LLLLLLL.LL',
            'L.L.L..L..',
            'LLLL.LL.LL',
            'L.LL.LL.LL',
            'L.LLLLL.LL',
            '..L.L.....',
            'LLLLLLLLLL',
            'L.LLLLLL.L',
            'L.LLLLL.LL',
        ];

        $this->assertEquals(26, $this->answer->two($grid));
    }

    /**
     * @dataProvider dataForGetNewGrid
     */
    public function testGetNewGrid($oldGrid, $expected)
    {
        $oldGrid = $this->answer->parseGrid($oldGrid);
        $expected = $this->answer->parseGrid($expected);
        $newGrid = $this->answer->getNewGrid($oldGrid, 'countOccupiedAdjacent', 4);

        $this->assertEquals($expected, $newGrid);
    }

    public function dataForGetNewGrid()
    {
        return [
            [
                [
                    'L.LL.LL.LL',
                    'LLLLLLL.LL',
                    'L.L.L..L..',
                    'LLLL.LL.LL',
                    'L.LL.LL.LL',
                    'L.LLLLL.LL',
                    '..L.L.....',
                    'LLLLLLLLLL',
                    'L.LLLLLL.L',
                    'L.LLLLL.LL',
                ],
                [
                    '#.##.##.##',
                    '#######.##',
                    '#.#.#..#..',
                    '####.##.##',
                    '#.##.##.##',
                    '#.#####.##',
                    '..#.#.....',
                    '##########',
                    '#.######.#',
                    '#.#####.##',
                ]
            ]
        ];
    }

    /**
     * @dataProvider dataForCountVisibleOccupied
     */
    public function testCountVisibleOccupied($grid, $row, $col, $expected)
    {
        $grid = $this->answer->parseGrid($grid);
        $this->assertEquals($expected, $this->answer->countVisibleOccupied($row, $col, $grid));
    }

    public function dataForCountVisibleOccupied()
    {
        return [
            [
                [
                    '.......#.',
                    '...#.....',
                    '.#.......',
                    '.........',
                    '..#L....#',
                    '....#....',
                    '.........',
                    '#........',
                    '...#.....',
                ],
                4,
                3,
                8,
            ],
            [
                [
                    '.............',
                    '.L.L.#.#.#.#.',
                    '.............',
                ],
                1,
                1,
                0,
            ],
            [
                [
                    '.##.##.',
                    '#.#.#.#',
                    '##...##',
                    '...L...',
                    '##...##',
                    '#.#.#.#',
                    '.##.##.',
                ],
                3,
                3,
                0,
            ],
        ];
    }
}