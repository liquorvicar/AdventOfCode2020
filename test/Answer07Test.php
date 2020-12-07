<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer07;
use AdventOfCode\App\BagRule;

class Answer07Test extends BaseTest
{
    /**
     * @var Answer07
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer07($this->logger);
    }

    public function testParseRules()
    {
        $input = [
            'light red bags contain 1 bright white bag, 2 muted yellow bags.',
            'dark orange bags contain 3 bright white bags, 4 muted yellow bags.',
            'bright white bags contain 1 shiny gold bag.',
            'muted yellow bags contain 2 shiny gold bags, 9 faded blue bags.',
            'shiny gold bags contain 1 dark olive bag, 2 vibrant plum bags.',
            'dark olive bags contain 3 faded blue bags, 4 dotted black bags.',
            'vibrant plum bags contain 5 faded blue bags, 6 dotted black bags.',
            'faded blue bags contain no other bags.',
            'dotted black bags contain no other bags.',
        ];

        $rules = $this->answer->parseRules($input);
        $this->assertCount(9, $rules);
        $firstRule = reset($rules);
        $firstColour = key($rules);
        $this->assertEquals('light red', $firstColour);
        $this->assertIsArray($firstRule);
        $this->assertCount(2, $firstRule);
        $contents = reset($firstRule);
        $this->assertInstanceOf(BagRule::class, $contents);
    }

    public function testCountBagsContaining()
    {
        $input = [
            'light red bags contain 1 bright white bag, 2 muted yellow bags.',
            'dark orange bags contain 3 bright white bags, 4 muted yellow bags.',
            'bright white bags contain 1 shiny gold bag.',
            'muted yellow bags contain 2 shiny gold bags, 9 faded blue bags.',
            'shiny gold bags contain 1 dark olive bag, 2 vibrant plum bags.',
            'dark olive bags contain 3 faded blue bags, 4 dotted black bags.',
            'vibrant plum bags contain 5 faded blue bags, 6 dotted black bags.',
            'faded blue bags contain no other bags.',
            'dotted black bags contain no other bags.',
        ];
        $rules = $this->answer->parseRules($input);
        $count = $this->answer->countBagsContaining('shiny gold', $rules);

        $this->assertEquals(4, $count);
    }

    public function testCountBagsInsideOriginalRules()
    {
        $input = [
            'light red bags contain 1 bright white bag, 2 muted yellow bags.',
            'dark orange bags contain 3 bright white bags, 4 muted yellow bags.',
            'bright white bags contain 1 shiny gold bag.',
            'muted yellow bags contain 2 shiny gold bags, 9 faded blue bags.',
            'shiny gold bags contain 1 dark olive bag, 2 vibrant plum bags.',
            'dark olive bags contain 3 faded blue bags, 4 dotted black bags.',
            'vibrant plum bags contain 5 faded blue bags, 6 dotted black bags.',
            'faded blue bags contain no other bags.',
            'dotted black bags contain no other bags.',
        ];
        $rules = $this->answer->parseRules($input);
        $bagsInside = $this->answer->countBagsInside('shiny gold', $rules);

        $this->assertEquals(32, $bagsInside);
    }

    public function testCountBagsInsideSecondExampleRules()
    {
        $input = [
            'shiny gold bags contain 2 dark red bags.',
            'dark red bags contain 2 dark orange bags.',
            'dark orange bags contain 2 dark yellow bags.',
            'dark yellow bags contain 2 dark green bags.',
            'dark green bags contain 2 dark blue bags.',
            'dark blue bags contain 2 dark violet bags.',
            'dark violet bags contain no other bags.',
        ];
        $rules = $this->answer->parseRules($input);
        $bagsInside = $this->answer->countBagsInside('shiny gold', $rules);

        $this->assertEquals(126, $bagsInside);
    }
}