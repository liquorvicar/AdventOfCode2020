<?php

namespace AdventOfCode;

class Answer15 extends Base
{

    public function one(array $input)
    {
        return $this->findXNumberSpoken($input, 2020);
    }

    public function two(array $input)
    {
        return $this->findXNumberSpoken($input, 30000000);
    }

    public function nextNumberSpoken($lastNumberSpoken, $countSpoken, array $numbers): int
    {
        $spokenBefore = $numbers[$lastNumberSpoken] ?? false;
        if ($spokenBefore === false) {
            return 0;
        }

        return ($countSpoken - 1 - $spokenBefore);
    }

    public function findXNumberSpoken(array $input, $x): int
    {
        $startingNumbers = array_map(function ($number) {
            return (int)trim($number);
        }, $input);
        $spoken = count($startingNumbers);
        $lastNumberSpoken = array_pop($startingNumbers);
        $numbers = [];
        foreach ($startingNumbers as $pos => $number) {
            $numbers[$number] = $pos;
        }
        while ($spoken < $x) {
            $nextNumber = $this->nextNumberSpoken($lastNumberSpoken, $spoken, $numbers);
            $numbers[$lastNumberSpoken] = $spoken - 1;
            $lastNumberSpoken = $nextNumber;
            $spoken++;
        }
        return $lastNumberSpoken;
    }
}

