<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer08;

class Answer08Test extends BaseTest
{
    /**
     * @var Answer08
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer08($this->logger);
    }

    public function testOne()
    {
        $program = [
            'nop +0',
            'acc +1',
            'jmp +4',
            'acc +3',
            'jmp -3',
            'acc -99',
            'acc +1',
            'jmp -4',
            'acc +6',
        ];

        $answer = $this->answer->one($program);

        $this->assertEquals(5, $answer);
    }

    public function testTwo()
    {
        $program = [
            'nop +0',
            'acc +1',
            'jmp +4',
            'acc +3',
            'jmp -3',
            'acc -99',
            'acc +1',
            'jmp -4',
            'acc +6',
        ];

        $answer = $this->answer->two($program);

        $this->assertEquals(8, $answer);
    }
}