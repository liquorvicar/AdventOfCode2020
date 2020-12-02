<?php

namespace AdventOfCode;

class Answer02 extends Base
{

    public function one(array $input)
    {
        $rules = array_map(function ($value) {
            return $this->parse($value);
        }, array_filter($input));
        $valid = 0;
        foreach ($rules as $rule) {
            if ($this->isValidSled($rule['password'], $rule['min'], $rule['max'], $rule['letter'])) {
                $valid++;
            }
        }

        return $valid;
    }

    public function two(array $input)
    {
        $rules = array_map(function ($value) {
            return $this->parse($value);
        }, array_filter($input));
        $valid = 0;
        foreach ($rules as $rule) {
            if ($this->isValidToboggan($rule['password'], $rule['min'], $rule['max'], $rule['letter'])) {
                $valid++;
            }
        }

        return $valid;
    }

    public function parse($input)
    {
        $inputParts = [];
        preg_match('/(\d+)-(\d+) ([a-z]): ([a-z]+)/i', $input, $inputParts);
        return [
            'min' => (int)$inputParts[1],
            'max' => (int)$inputParts[2],
            'letter' => $inputParts[3],
            'password' => $inputParts[4],
        ];
    }

    public function isValidSled(string $password, int $min, int $max, string $ruleLetter)
    {
        $count = 0;
        foreach (str_split($password) as $letter) {
            if ($letter === $ruleLetter) {
                $count++;
            }
        }

        return $min <= $count && $count <= $max;
    }

    public function isValidToboggan($password, $first, $second, $letter)
    {
        return ($password[$first - 1] === $letter) xor ($password[$second - 1] === $letter);
    }
}

