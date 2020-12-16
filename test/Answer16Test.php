<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer16;

class Answer16Test extends BaseTest
{
    /**
     * @var Answer16
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer16($this->logger);
    }

    public function testParseInput()
    {
        $input = [
            'class: 1-3 or 5-7',
            'row: 6-11 or 33-44',
            'seat: 13-40 or 45-50',
            '',
            'your ticket:',
            '7,1,14',
            '',
            'nearby tickets:',
            '7,3,47',
            '40,4,50',
            '55,2,20',
            '38,6,12',
        ];

        list($rules, $myTicket, $otherTickets) = $this->answer->parseInput($input);
        $this->assertCount(3, $rules);
        $this->assertArrayHasKey('row', $rules);
        $this->assertCount(18, $rules['row']);
        $this->assertCount(3, $myTicket);
        $this->assertCount(4, $otherTickets);
    }

    public function testOne()
    {
        $input = [
            'class: 1-3 or 5-7',
            'row: 6-11 or 33-44',
            'seat: 13-40 or 45-50',
            '',
            'your ticket:',
            '7,1,14',
            '',
            'nearby tickets:',
            '7,3,47',
            '40,4,50',
            '55,2,20',
            '38,6,12',
        ];

        $this->assertEquals(71, $this->answer->one($input));
    }

    public function testFindFieldOrder()
    {
        $input = [
            'class: 0-1 or 4-19',
            'row: 0-5 or 8-19',
            'seat: 0-13 or 16-19',
            '',
            'your ticket:',
            '11,12,13',
            '',
            'nearby tickets:',
            '3,9,18',
            '15,1,5',
            '5,14,9',
            '',
        ];
        $fieldOrder = ['row', 'class', 'seat'];
        list($rules, $myTicket, $tickets) = $this->answer->parseInput($input);
        $tickets[] = $myTicket;
        $this->assertEquals($fieldOrder, $this->answer->findFieldOrder($tickets, $rules));
    }
}