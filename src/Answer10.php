<?php

namespace AdventOfCode;

class Answer10 extends Base
{

    public function one(array $input)
    {
        $adapters = $this->numbers($input);
        rsort($adapters);
        $highest = reset($adapters);
        array_push($adapters, ($highest + 3));
        sort($adapters);
        $differences = [1 => 0, 2 => 0, 3 => 0];
        $previous = 0;
        while (!empty($adapters)) {
            $current = array_shift($adapters);
            if ($current > ($previous + 3)) {
                throw new \Exception('Ooops somethings wrong');
            }
            $difference = $current - $previous;
            $differences[$difference]++;
            $previous = $current;
        }

        return $differences[1] * $differences[3];
    }

    public function two(array $input)
    {
        $adapters = $this->numbers($input);
        sort($adapters);

        return $this->countChains(0, $adapters);
    }

    private function countChains(int $current, array $adapters)
    {
        if (empty($adapters)) {
            return 1;
        }
        $count = 0;
        $index = 0;
        while ($index < count($adapters)) {
            if ($adapters[$index] > ($current + 3)) {
                break;
            }
            $count += $this->countChains($adapters[$index], array_slice($adapters, ($index + 1)));
            $index++;
        }
        $this->logger->debug('Counting', ['current' => $current, 'count' => $count]);

        return $count;
    }
}

