<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer09;

class Answer09Test extends BaseTest
{
    /**
     * @var Answer09
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer09($this->logger);
    }

    public function testFindFirstInvalid()
    {
        $input = [
            35,
            20,
            15,
            25,
            47,
            40,
            62,
            55,
            65,
            95,
            102,
            117,
            150,
            182,
            127,
            219,
            299,
            277,
            309,
            576,
        ];
        $this->assertEquals(127, $this->answer->findFirstInvalid($input, 5));
    }

    public function testFindWeakness()
    {
        $input = [
            35,
            20,
            15,
            25,
            47,
            40,
            62,
            55,
            65,
            95,
            102,
            117,
            150,
            182,
            127,
            219,
            299,
            277,
            309,
            576,
        ];
        $this->assertEquals(62, $this->answer->findWeakness($input, 5));
    }
}