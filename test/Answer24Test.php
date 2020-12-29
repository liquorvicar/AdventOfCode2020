<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer24;

class Answer24Test extends BaseTest
{
    /**
     * @var Answer24
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer24($this->logger);
    }

    public function testOne()
    {
        $input = [
            'sesenwnenenewseeswwswswwnenewsewsw',
            'neeenesenwnwwswnenewnwwsewnenwseswesw',
            'seswneswswsenwwnwse',
            'nwnwneseeswswnenewneswwnewseswneseene',
            'swweswneswnenwsewnwneneseenw',
            'eesenwseswswnenwswnwnwsewwnwsene',
            'sewnenenenesenwsewnenwwwse',
            'wenwwweseeeweswwwnwwe',
            'wsweesenenewnwwnwsenewsenwwsesesenwne',
            'neeswseenwwswnwswswnw',
            'nenwswwsewswnenenewsenwsenwnesesenew',
            'enewnwewneswsewnwswenweswnenwsenwsw',
            'sweneswneswneneenwnewenewwneswswnese',
            'swwesenesewenwneswnwwneseswwne',
            'enesenwswwswneneswsenwnewswseenwsese',
            'wnwnesenesenenwwnenwsewesewsesesew',
            'nenewswnwewswnenesenwnesewesw',
            'eneswnwswnwsenenwnwnwwseeswneewsenese',
            'neswnwewnwnwseenwseesewsenwsweewe',
            'wseweeenwnesenwwwswnew',
        ];
        $this->assertEquals(10, $this->answer->one($input));
    }

    public function testFindTile()
    {
        $this->assertEquals([0, 0], $this->answer->findTile(['nw', 'w', 'sw', 'e', 'e']));
        $this->assertEquals([0, 0], $this->answer->findTile(['e', 'w']));
        $this->assertEquals([0, 0], $this->answer->findTile(['ne', 'sw',]));
        $this->assertEquals([0, 0], $this->answer->findTile(['se', 'nw',]));
        $this->assertEquals([0, 0], $this->answer->findTile(['ne', 'se', 'w',]));
        $this->assertEquals([0, 0], $this->answer->findTile(['nw', 'sw', 'e']));
        $this->assertEquals([0, 0], $this->answer->findTile(['se', 'w', 'ne',]));
        $this->assertEquals([0, 0], $this->answer->findTile(['ne', 'se', 'sw', 'w', 'ne']));
    }

    /**
     * @dataProvider dataForCountTilesAfterXDays
     */
    public function testCountTilesAfterXDays($days, $count)
    {
        $input = [
            'sesenwnenenewseeswwswswwnenewsewsw',
            'neeenesenwnwwswnenewnwwsewnenwseswesw',
            'seswneswswsenwwnwse',
            'nwnwneseeswswnenewneswwnewseswneseene',
            'swweswneswnenwsewnwneneseenw',
            'eesenwseswswnenwswnwnwsewwnwsene',
            'sewnenenenesenwsewnenwwwse',
            'wenwwweseeeweswwwnwwe',
            'wsweesenenewnwwnwsenewsenwwsesesenwne',
            'neeswseenwwswnwswswnw',
            'nenwswwsewswnenenewsenwsenwnesesenew',
            'enewnwewneswsewnwswenweswnenwsenwsw',
            'sweneswneswneneenwnewenewwneswswnese',
            'swwesenesewenwneswnwwneseswwne',
            'enesenwswwswneneswsenwnewswseenwsese',
            'wnwnesenesenenwwnenwsewesewsesesew',
            'nenewswnwewswnenesenwnesewesw',
            'eneswnwswnwsenenwnwnwwseeswneewsenese',
            'neswnwewnwnwseenwseesewsenwsweewe',
            'wseweeenwnesenwwwswnew',
        ];
        $this->assertEquals($count, $this->answer->countTilesAfterXDays($input, $days));
    }

    public function dataForCountTilesAfterXDays()
    {
        return [
            [1, 15],
            [2, 12],
            [3, 25],
            [4, 14],
            [5, 23],
            [6, 28],
            [7, 41],
            [8, 37],
            [9, 49],
            [10, 37],
            [20, 132],
            [50, 566],
            [100, 2208],
        ];
    }
}