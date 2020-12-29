<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer19;

class Answer19Test extends BaseTest
{
    /**
     * @var Answer19
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer19($this->logger);
    }

    /**
     * @dataProvider dataForParseRules
     */
    public function testParseRules($input, $rules)
    {
        $this->assertEquals($rules, $this->answer->parseRules($input));
    }

    public function dataForParseRules()
    {
        return [
            [
                [
                    '0: 1 2',
                    '1: "a"',
                    '2: 1 3 | 3 1',
                    '3: "b"',
                ],
                [
                    'a(?:ab|ba)',
                    'a',
                    'ab|ba',
                    'b',
                ]
            ],
            [
                [
                    '0: 4 1 5',
                    '1: 2 3 | 3 2',
                    '2: 4 4 | 5 5',
                    '3: 4 5 | 5 4',
                    '4: "a"',
                    '5: "b"',
                ],
                [
                    'a(?:(?:aa|bb)(?:ab|ba)|(?:ab|ba)(?:aa|bb))b',
                    '(?:aa|bb)(?:ab|ba)|(?:ab|ba)(?:aa|bb)',
                    'aa|bb',
                    'ab|ba',
                    'a',
                    'b',
                ]
            ],
            [
                [
                    '8: 42 | 42 8',
                    '11: 42 31 | 42 11 31',
                    '42: "a"',
                    '31: "b"',
                ],
                [
                    8 => '(?<r8sr42>a)+',
                    11 => '(?<r11sr42>a)+(?<r11sr31>b)+',
                    42 => 'a',
                    31 => 'b',
                ]
            ]
        ];
    }

    public function testOne()
    {
        $input = [
            '0: 4 1 5',
            '1: 2 3 | 3 2',
            '2: 4 4 | 5 5',
            '3: 4 5 | 5 4',
            '4: "a"',
            '5: "b"',
            '',
            'ababbb',
            'bababa',
            'abbbab',
            'aaabbb',
            'aaaabbb',
        ];
        $this->assertEquals(2, $this->answer->one($input));
    }

    public function testOneWithExampleTwo()
    {
        $input = [
            '42: 9 14 | 10 1',
            '9: 14 27 | 1 26',
            '10: 23 14 | 28 1',
            '1: "a"',
            '11: 42 31',
            '5: 1 14 | 15 1',
            '19: 14 1 | 14 14',
            '12: 24 14 | 19 1',
            '16: 15 1 | 14 14',
            '31: 14 17 | 1 13',
            '6: 14 14 | 1 14',
            '2: 1 24 | 14 4',
            '0: 8 11',
            '13: 14 3 | 1 12',
            '15: 1 | 14',
            '17: 14 2 | 1 7',
            '23: 25 1 | 22 14',
            '28: 16 1',
            '4: 1 1',
            '20: 14 14 | 1 15',
            '3: 5 14 | 16 1',
            '27: 1 6 | 14 18',
            '14: "b"',
            '21: 14 1 | 1 14',
            '25: 1 1 | 1 14',
            '22: 14 14',
            '8: 42',
            '26: 14 22 | 1 20',
            '18: 15 15',
            '7: 14 5 | 1 21',
            '24: 14 1',
            '',
            'abbbbbabbbaaaababbaabbbbabababbbabbbbbbabaaaa',
            'bbabbbbaabaabba',
            'babbbbaabbbbbabbbbbbaabaaabaaa',
            'aaabbbbbbaaaabaababaabababbabaaabbababababaaa',
            'bbbbbbbaaaabbbbaaabbabaaa',
            'bbbababbbbaaaaaaaabbababaaababaabab',
            'ababaaaaaabaaab',
            'ababaaaaabbbaba',
            'baabbaaaabbaaaababbaababb',
            'abbbbabbbbaaaababbbbbbaaaababb',
            'aaaaabbaabaaaaababaa',
            'aaaabbaaaabbaaa',
            'aaaabbaabbaaaaaaabbbabbbaaabbaabaaa',
            'babaaabbbaaabaababbaabababaaab',
            'aabbbbbaabbbaaaaaabbbbbababaaaaabbaaabba',
        ];
        $this->assertEquals(3, $this->answer->one($input));
    }

    public function testTwoWithRealInput()
    {
        $input = file(__DIR__ . '/../input/19.txt');
        $this->assertEquals(405, $this->answer->two($input));
    }
}