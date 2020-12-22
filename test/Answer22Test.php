<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer22;

class Answer22Test extends BaseTest
{
    /**
     * @var Answer22
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer22($this->logger);
    }

    public function testPlayRound()
    {
        $startingHands = [
            [ 9, 2, 6, 3, 1 ],
            [ 5, 8, 4, 7, 10 ],
        ];
        $endingHands = [
            [2, 6, 3, 1, 9, 5],
            [8, 4, 7, 10],
        ];
        $this->assertEquals($endingHands, $this->answer->playRound($startingHands, false));
    }

    public function testPlayGame()
    {
        $startingHands = [
            [ 9, 2, 6, 3, 1 ],
            [ 5, 8, 4, 7, 10 ],
        ];
        $this->assertEquals(306, $this->answer->playGame($startingHands));
    }

    public function testPlayRecursiveGame()
    {
        $startingHands = [
            [ 9, 2, 6, 3, 1 ],
            [ 5, 8, 4, 7, 10 ],
        ];
        $this->assertEquals(291, $this->answer->playGame($startingHands, true));
    }

    public function testPlayRecursiveGameWithBreak()
    {
        $startingHands = [
            [ 43, 19 ],
            [ 2, 29, 14 ],
        ];
        $this->assertGreaterThan(0, $this->answer->playGame($startingHands, true));
    }
}