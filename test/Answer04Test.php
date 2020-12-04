<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer04;

class Answer04Test extends BaseTest
{
    /**
     * @var Answer04
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer04($this->logger);
    }

    public function testParsePassports()
    {
        $input = [
            'ecl:gry pid:860033327 eyr:2020 hcl:#fffffd',
            'byr:1937 iyr:2017 cid:147 hgt:183cm',
            '',
            'iyr:2013 ecl:amb cid:350 eyr:2023 pid:028048884',
            'hcl:#cfa07d byr:1929',
            '',
            'hcl:#ae17e1 iyr:2013',
            'eyr:2024',
            'ecl:brn pid:760753108 byr:1931',
            'hgt:179cm',
            '',
            'hcl:#cfa07d eyr:2025 pid:166559648',
            'iyr:2011 ecl:brn hgt:59in',
        ];
        $passports = $this->answer->parse($input);
        $this->assertCount(4, $passports);
    }

    /**
     * @dataProvider dataForValidatePassportFields
     */
    public function testValidatePassportFields(string $passport, bool $isValid)
    {
        $result = $this->answer->validatePassportFields($passport);
        $this->assertEquals($isValid, $result);
    }

    public function dataForValidatePassportFields()
    {
        return [
            ['ecl:gry pid:860033327 eyr:2020 hcl:#fffffd byr:1937 iyr:2017 cid:147 hgt:183cm', true],
            ['iyr:2013 ecl:amb cid:350 eyr:2023 pid:028048884 hcl:#cfa07d byr:1929', false],
            ['hcl:#ae17e1 iyr:2013 eyr:2024 ecl:brn pid:760753108 byr:1931 hgt:179cm', true],
            ['hcl:#cfa07d eyr:2025 pid:166559648 iyr:2011 ecl:brn hgt:59in', false],
        ];
    }

    /**
     * @dataProvider dataForValidateFieldValue
     */
    public function testValidateFieldValue(string $field, bool $isValid, string $value)
    {
        $result = $this->answer->validateFieldValue($field, $value);

        $this->assertEquals($isValid, $result);
    }
    
    public function dataForValidateFieldValue()
    {
        return [
            ['byr', true,   '2002',],
            ['byr', false, '2003',],
            ['hgt', true,   '60in',],
            ['hgt', true,   '190cm',],
            ['hgt', false, '190in',],
            ['hgt', false, '190',],
            ['hcl', true,   '#123abc',],
            ['hcl', false, '#123abz',],
            ['hcl', false, '123abc',],
            ['ecl', true,   'brn',],
            ['ecl', false, 'wat',],
            ['pid', true,   '000000001',],
            ['pid', false, '0123456789',],
        ];
    }

    /**
     * @dataProvider dataForValidatePassport
     */
    public function testValidatePassport(string $passport, bool $isValid)
    {
        list($passport) = $this->answer->parse([$passport]);

        $result = $this->answer->validatePassport($passport);

        $this->assertEquals($isValid, $result);
    }

    public function dataForValidatePassport()
    {
        return [
            ['eyr:1972 cid:100 hcl:#18171d ecl:amb hgt:170 pid:186cm iyr:2018 byr:1926', false],
            ['iyr:2019 hcl:#602927 eyr:1967 hgt:170cm ecl:grn pid:012533040 byr:1946', false],
            ['hcl:dab227 iyr:2012 ecl:brn hgt:182cm pid:021572410 eyr:2020 byr:1992 cid:277', false],
            ['hgt:59cm ecl:zzz eyr:2038 hcl:74454a iyr:2023 pid:3556412378 byr:2007', false],
            ['pid:087499704 hgt:74in ecl:grn iyr:2012 eyr:2030 byr:1980 hcl:#623a2f', true],
            ['eyr:2029 ecl:blu cid:129 byr:1989 iyr:2014 pid:896056539 hcl:#a97842 hgt:165cm', true],
            ['hcl:#888785 hgt:164cm byr:2001 iyr:2015 cid:88 pid:545766238 ecl:hzl eyr:2022', true],
            ['iyr:2010 hgt:158cm hcl:#b6652a ecl:blu byr:1944 eyr:2021 pid:093154719', true],
        ];
    }
}