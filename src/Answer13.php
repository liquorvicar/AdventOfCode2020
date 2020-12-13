<?php

namespace AdventOfCode;

class Answer13 extends Base
{

    public function one(array $input)
    {
        $startTime = (int)trim($input[0]);
        $buses = array_filter(explode(',', trim($input[1])), function ($bus) {
            return $bus !== 'x';
        });
        $this->logger->debug('Found buses', $buses);
        $buses = array_map(function ($bus) {
            return (int)$bus;
        }, $buses);
        $earliestTime = $this->findEarliestBus($startTime, $buses);

        return $earliestTime[0] * ($earliestTime[1] - $startTime);
    }

    public function two(array $input)
    {
        $buses = array_map(function ($bus) {
            return $bus === 'x' ? $bus : (int)$bus;
        }, explode(',', trim($input[1])));

        return $this->findDeparturesInOrder($buses, 100000000000000);
    }

    public function findEarliestBus(int $startTime, array $buses): array
    {
        sort($buses);
        $found = false;
        while (!$found) {
            $possibleBuses = array_filter($buses, function ($bus) use ($startTime) {
                return ($startTime % $bus) === 0;
            });
            if (!empty($possibleBuses)) {
                return [reset($possibleBuses), $startTime];
            }
            $startTime++;
        }

        return [];
    }

    public function findDeparturesInOrder(array $buses, $time = 0)
    {
        $busesToCheck = [];
        foreach ($buses as $offset => $bus) {
            if ($bus !== 'x') {
                $busesToCheck[$bus] = $offset;
            }
        }
        krsort($busesToCheck);
        array_walk($busesToCheck, function (&$value, $key) {
            $value = ($key - $value);
        });

        return $this->findMinX(array_keys($busesToCheck), array_values($busesToCheck), count($busesToCheck));
    }

    private function findMinX($num, $rem, $k)
    {
        // Compute product of all numbers
        $prod = 1;
        for ($i = 0; $i < $k; $i++)
            $prod *= $num[$i];

        // Initialize result
        $result = 0;

        // Apply above formula
        for ($i = 0; $i < $k; $i++)
        {
            $pp = (int)$prod / $num[$i];
            $result += $rem[$i] * $this->inv($pp,
                    $num[$i]) * $pp;
        }

        return $result % $prod;
    }

    function inv($a, $m)
    {
        $m0 = $m;
        $x0 = 0;
        $x1 = 1;

        if ($m == 1)
            return 0;

        // Apply extended Euclid Algorithm
        while ($a > 1)
        {
            // q is quotient
            $q = (int)($a / $m);

            $t = $m;

            // m is remainder now, process
            // same as euclid's algo
            $m = $a % $m;
            $a = $t;

            $t = $x0;

            $x0 = $x1 - $q * $x0;

            $x1 = $t;
        }

        // Make x1 positive
        if ($x1 < 0)
            $x1 += $m0;

        return $x1;
    }
}

