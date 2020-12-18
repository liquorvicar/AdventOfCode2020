<?php

namespace AdventOfCode;

class Answer18 extends Base
{

    public function one(array $input)
    {
        $input = $this->trim($input);

        return array_reduce($input, function ($sum, $expression) {
            return $sum + $this->evaluate($expression);
        }, 0);
    }

    public function two(array $input)
    {
        $input = $this->trim($input);

        return array_reduce($input, function ($sum, $expression) {
            return $sum + $this->evaluate($expression, true);
        }, 0);
    }

    public function evaluate(string $expression, $usePrecedence = false): int
    {
        do {
            $matches = [];
            preg_match_all('(\([0-9]+( [+*] [0-9]+)+\))', $expression, $matches);
            foreach ($matches[0] as $subExpression) {
                $value = $this->evaluate(trim($subExpression, '()'), $usePrecedence);
                $expression = str_replace($subExpression, $value, $expression);
            }
        } while (!empty($matches[0]));

        if ($usePrecedence) {
            do {
                $matches = [];
                preg_match('([0-9]+ \+ [0-9]+)', $expression, $matches);
                if (!empty($matches[0])) {
                    $subExpression = $matches[0];
                    $value = $this->evaluate($subExpression);
                    $pos = strpos($expression, $subExpression);
                    $expression = substr_replace($expression, $value, $pos, strlen($subExpression));
                }
            } while (!empty($matches[0]));
        }
        $total = 0;
        $operator = null;
        $operands = explode(' ', $expression);
        while (!empty($operands)) {
            $operand = trim(array_shift($operands));
            if (!$operand) {
                continue;
            }
            if ($operand === '+' || $operand === '*') {
                $operator = $operand;
            } else {
                $operand = (int)$operand;
                $operator = $operator ?? '+';
                if ($operator === '+') {
                    $total += $operand;
                } else {
                    $total = $total * $operand;
                }
            }
        }

        return $total;
    }
}

