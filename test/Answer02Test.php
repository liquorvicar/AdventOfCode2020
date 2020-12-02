<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer02;

class Answer02Test extends BaseTest
{
    /**
     * @var Answer02
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer02($this->logger);
    }

    /**
     * @dataProvider dataForParseInput
     */
    public function testParseInput($input, $min, $max, $letter, $password)
    {
        $expected = [
            'min' => $min,
            'max' => $max,
            'letter' => $letter,
            'password' => $password,
        ];
        $this->assertEquals($expected, $this->answer->parse($input));
    }

    public function dataForParseInput()
    {
        return [
            ['1-3 a: abcde', 1, 3, 'a', 'abcde'],
            ['1-3 b: cdefg', 1, 3, 'b', 'cdefg'],
            ['2-9 c: ccccccccc', 2, 9, 'c', 'ccccccccc'],
            ['2-19 c: ccccccccc', 2, 19, 'c', 'ccccccccc'],
        ];
    }

    /**
     * @dataProvider dataForIsValidSled
     */
    public function testIsValidSled($min, $max, $letter, $password, $isValid)
    {
        $this->assertEquals($isValid, $this->answer->isValidSled($password, $min, $max, $letter));
    }

    public function dataForIsValidSled()
    {
        return [
            [1, 3, 'a', 'abcde', true],
            [1, 3, 'b', 'cdefg', false],
            [2, 9, 'c', 'ccccccccc', true],
        ];
    }

    /**
     * @dataProvider dataForIsValidToboggan
     */
    public function testIsValidToboggan($first, $second, $letter, $password, $isValid)
    {
        $this->assertEquals($isValid, $this->answer->isValidToboggan($password, $first, $second, $letter));
    }

    public function dataForIsValidToboggan()
    {
        return [
            [1, 3, 'a', 'abcde', true],
            [1, 3, 'b', 'cdefg', false],
            [2, 9, 'c', 'ccccccccc', true],
        ];
    }

    public function testPartOne()
    {
        $input = [
            '1-3 a: abcde',
            '1-3 b: cdefg',
            '2-9 c: ccccccccc',
        ];
        $this->assertEquals(2, $this->answer->one($input));
    }
}