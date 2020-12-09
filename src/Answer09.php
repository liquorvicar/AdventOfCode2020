<?php

namespace AdventOfCode;

class Answer09 extends Base
{

    public function one(array $input)
    {
        $numbers = $this->numbers($input);

        return $this->findFirstInvalid($numbers);
    }

    public function two(array $input)
    {
        $numbers = $this->numbers($input);

        return $this->findWeakness($numbers);
    }

    public function findFirstInvalid(array $numbers, int $seedLength = 25)
    {
        $seed = array_slice($numbers, 0, $seedLength);
        $numbersToCheck = array_slice($numbers, $seedLength);
        foreach ($numbersToCheck as $number) {
            $valid = false;
            foreach ($seed as $a) {
                foreach ($seed as $b) {
                    if ($a === $b) {
                        continue;
                    }
                    if (($a + $b) === $number) {
                        $valid = true;
                        array_shift($seed);
                        array_push($seed, $number);
                        break 2;
                    }
                }
            }
            if (!$valid) {
                return $number;
            }
        }

        return 0;
    }

    public function findWeakness(array $numbers, int $seedLength = 25)
    {
        $firstInvalid = $this->findFirstInvalid($numbers, $seedLength);
        $parts = [];

        foreach ($numbers as $start => $number) {
            $pos = $start;
            $sum = 0;
            $parts = [];
            do {
                $parts[] = $numbers[$pos];
                $sum += $numbers[$pos];
                if ($sum === $firstInvalid) {
                    break 2;
                }
                $pos++;
            } while ($sum < $firstInvalid);
        }
        sort($parts);
        $first = array_shift($parts) ?? 0;
        $last = array_pop($parts) ?? 0;

        return $first + $last;
    }
}

