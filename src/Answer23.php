<?php

namespace AdventOfCode;

class Answer23 extends Base
{

    public function one(array $input)
    {
        $input = reset($input);
        $final = $this->makeMoves(trim($input), 100);
        $one = array_search(1, $final);
        $final = array_merge(array_slice($final, $one + 1), array_slice($final, 0, $one));

        return implode($final);
    }

    public function two(array $input)
    {
        $input = reset($input);
        $final = $this->makeMoves(trim($input), 10000000, true);
        $one = array_search(1, $final);

        return $final[$one + 1] * $final[$one + 2];
    }

    public function makeMoves(string $cups, int $numMoves, $MillionCups = false): array
    {
        $currentPos = 0;
        $cups = array_map('intval', str_split($cups));
        if ($MillionCups) {
            $max = max($cups);
            while (count($cups) < 1000000) {
                $max += 1;
                $cups[] = $max;
            }
        }
        $numCups = count($cups);
        for ($i = 1; $i <= $numMoves; $i++) {
            if ($i % 10000 === 0) {
                $this->logger->debug('Move', ['move' => $i]);
            }
            $currentCup = array_shift($cups);
            $cups[] = $currentCup;
            $extract = [];
            while (count($extract) < 3) {
                $extract[] = array_shift($cups);
            }
            $found = false;
            $newCup = $currentCup;
            while (!$found) {
                $newCup = ($newCup - 1);
                if ($newCup < 1) {
                    $newCup = $numCups;
                }
                if (array_search($newCup, $extract) === false) {
                    $found = true;
                }
            }
            $done = false;
            while (!$done) {
                $cup = array_shift($cups);
                $cups[] = $cup;
                if ($cup === $newCup) {
                    $cups = array_merge($cups, $extract);
                    $extract = [];
                }
                if (empty($extract) && $cup === $currentCup) {
                    $done = true;
                }
            }
        }

        return $cups;
    }
}

