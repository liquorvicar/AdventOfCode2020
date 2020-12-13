<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer13;

class Answer13Test extends BaseTest
{
    /**
     * @var Answer13
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer13($this->logger);
    }

    public function testFindEarliestBus()
    {
        $startTime = 939;
        $buses = [7,13,59,31,19];

        $this->assertEquals([59, 944], $this->answer->findEarliestBus($startTime, $buses));
    }

    public function testOne()
    {
        $input = [
            '939',
            '7,13,x,x,59,x,31,19',
        ];
        $this->assertEquals(295, $this->answer->one($input));
    }

    /**
     * @dataProvider dataForFindDeparturesInOrder
     */
    public function testFindDeparturesInOrder($buses, $earliestTime)
    {
        $this->assertEquals($earliestTime, $this->answer->findDeparturesInOrder($buses));
    }

    public function dataForFindDeparturesInOrder()
    {
        return [
            [[7,13,'x','x',59,'x',31,19], 1068781],
            [[17,'x',13,19], 3417],
            [[67,7,59,61], 754018],
            [[67,'x',7,59,61], 779210],
            [[67,7,'x',59,61], 1261476],
            [[1789,37,47,1889], 1202161486],
        ];
    }
}