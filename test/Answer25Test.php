<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer25;

class Answer25Test extends BaseTest
{
    /**
     * @var Answer25
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer25($this->logger);
    }

    /**
     * @dataProvider dataForGetLoopSize
     */
    public function testGetLoopSize($publicKey, $loopSize)
    {
        $this->assertEquals($loopSize, $this->answer->getLoopSize($publicKey));
    }

    public function dataForGetLoopSize()
    {
        return [
            [5764801, 8],
            [17807724, 11],
        ];
    }

    public function testGetEncyptionKey()
    {
        $this->assertEquals(14897079, $this->answer->getEncryptionKey(5764801, 11));
    }
}