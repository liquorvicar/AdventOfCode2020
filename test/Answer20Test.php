<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer20;

class Answer20Test extends BaseTest
{
    /**
     * @var Answer20
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer20($this->logger);
    }

    public function testParseInput()
    {
        $tiles = $this->answer->parseInput($this->input());
        $this->assertCount(9, $tiles);
        $this->assertArrayHasKey(2311, $tiles);
        $this->assertCount(10, $tiles[2311]);
    }

    public function testOne()
    {
        $expected = 20899048083289;
        $this->assertEquals($expected, $this->answer->one($this->input()));
    }


    public function testTwo()
    {
        $expected = 273;
        $this->assertEquals($expected, $this->answer->two($this->input()));
    }

    public function input()
    {
        return [
            'Tile 2311:',
            '..##.#..#.',
            '##..#.....',
            '#...##..#.',
            '####.#...#',
            '##.##.###.',
            '##...#.###',
            '.#.#.#..##',
            '..#....#..',
            '###...#.#.',
            '..###..###',
            '',
            'Tile 1951:',
            '#.##...##.',
            '#.####...#',
            '.....#..##',
            '#...######',
            '.##.#....#',
            '.###.#####',
            '###.##.##.',
            '.###....#.',
            '..#.#..#.#',
            '#...##.#..',
            '',
            'Tile 1171:',
            '####...##.',
            '#..##.#..#',
            '##.#..#.#.',
            '.###.####.',
            '..###.####',
            '.##....##.',
            '.#...####.',
            '#.##.####.',
            '####..#...',
            '.....##...',
            '',
            'Tile 1427:',
            '###.##.#..',
            '.#..#.##..',
            '.#.##.#..#',
            '#.#.#.##.#',
            '....#...##',
            '...##..##.',
            '...#.#####',
            '.#.####.#.',
            '..#..###.#',
            '..##.#..#.',
            '',
            'Tile 1489:',
            '##.#.#....',
            '..##...#..',
            '.##..##...',
            '..#...#...',
            '#####...#.',
            '#..#.#.#.#',
            '...#.#.#..',
            '##.#...##.',
            '..##.##.##',
            '###.##.#..',
            '',
            'Tile 2473:',
            '#....####.',
            '#..#.##...',
            '#.##..#...',
            '######.#.#',
            '.#...#.#.#',
            '.#########',
            '.###.#..#.',
            '########.#',
            '##...##.#.',
            '..###.#.#.',
            '',
            'Tile 2971:',
            '..#.#....#',
            '#...###...',
            '#.#.###...',
            '##.##..#..',
            '.#####..##',
            '.#..####.#',
            '#..#.#..#.',
            '..####.###',
            '..#.#.###.',
            '...#.#.#.#',
            '',
            'Tile 2729:',
            '...#.#.#.#',
            '####.#....',
            '..#.#.....',
            '....#..#.#',
            '.##..##.#.',
            '.#.####...',
            '####.#.#..',
            '##.####...',
            '##..#.##..',
            '#.##...##.',
            '',
            'Tile 3079:',
            '#.#.#####.',
            '.#..######',
            '..#.......',
            '######....',
            '####.#..#.',
            '.#...#.##.',
            '#.#####.##',
            '..#.###...',
            '..#.......',
            '..#.###...',
            '',
        ];
    }

    public function testCountMonsters()
    {
        $image = [
            '.####...#####..#...###..',
            '#####..#..#.#.####..#.#.',
            '.#.#...#.###...#.##.##..',
            '#.#.##.###.#.##.##.#####',
            '..##.###.####..#.####.##',
            '...#.#..##.##...#..#..##',
            '#.##.#..#.#..#..##.#.#..',
            '.###.##.....#...###.#...',
            '#.####.#.#....##.#..#.#.',
            '##...#..#....#..#...####',
            '..#.##...###..#.#####..#',
            '....#.##.#.#####....#...',
            '..##.##.###.....#.##..#.',
            '#...#...###..####....##.',
            '.#.##...#.##.#.#.###...#',
            '#.###.#..####...##..#...',
            '#.###...#.##...#.######.',
            '.###.###.#######..#####.',
            '..##.#..#..#.#######.###',
            '#.#..##.########..#..##.',
            '#.#####..#.#...##..#....',
            '#....##..#.#########..##',
            '#...#.....#..##...###.##',
            '#..###....##.#...##.##.#',
        ];
        $image = array_map('str_split', $image);
        $this->assertEquals(30, $this->answer->countMonsters($image));
    }
}