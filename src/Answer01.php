<?php

namespace AdventOfCode;

class Answer01 extends Base
{

    public function one(array $input)
    {
        $numbers = $this->numbers($input);
        foreach ($numbers as $pos1 => $number1) {
            foreach ($numbers as $pos2 => $number2) {
                if ($pos1 === $pos2) {
                    continue;
                }
                if (($number1 + $number2) === 2020) {
                    return $number1 * $number2;
                }
            }
        }
        return 0;
    }

    public function two(array $input)
    {
        $numbers = $this->numbers($input);
        foreach ($numbers as $pos1 => $number1) {
            foreach ($numbers as $pos2 => $number2) {
                if ($pos1 === $pos2) {
                    continue;
                }
                foreach ($numbers as $pos3 => $number3) {
                    if ($pos1 === $pos3 || $pos2 === $pos3) {
                        continue;
                    }
                    if (($number1 + $number2 + $number3) === 2020) {
                        return $number1 * $number2 * $number3;
                    }
                }
            }
        }
        return 0;
    }

}
