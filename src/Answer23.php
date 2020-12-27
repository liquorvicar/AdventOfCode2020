<?php

namespace AdventOfCode;

class Answer23 extends Base
{

    public function one(array $input)
    {
        $input = reset($input);
        $final = $this->makeMoves(trim($input), 100);
        $next = $final[1]['next'];
        $output = '';
        while ($next !== 1) {
            $output.= (string)$next;
            $next = $final[$next]['next'];
        }

        return $output;
    }

    public function two(array $input)
    {
        $input = reset($input);
        $final = $this->makeMoves(trim($input), 10000000, true);
        $next = $final[1]['next'];

        return $next * $final[$next]['next'];
    }

    public function makeMoves(string $cups, int $numMoves, $MillionCups = false): array
    {
        $rawCups = str_split($cups);
        $cups = [];
        $last = null;
        $first = $next = (int)array_shift($rawCups);
        while (!empty($rawCups)) {
            $current = $next;
            $next = (int)array_shift($rawCups);
            $cups[$current] = [
                'next' => $next,
            ];
        }
        $last = $next;
        $cups[$next] = [
            'next' => null,
        ];
        if ($MillionCups) {
            $next = max(array_keys($cups));
            $next += 1;
            $cups[$last]['next'] = $next;
            while (count($cups) < 1000000) {
                $current = $last = $next;
                $next += 1;
                $cups[$current] = [
                    'next' => $next,
                ];
            }
        }
        $cups[$last]['next'] = $first;
        $numCups = count($cups);
        reset($cups);
        $currentCup = key($cups);
        for ($i = 1; $i <= $numMoves; $i++) {
            $extract = [];
            $nextExtract = $currentCup;
            while (count($extract) < 3) {
                $nextExtract = $cups[$nextExtract]['next'];
                $extract[] = $nextExtract;
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
            $afterExtract = $cups[$extract[2]]['next'];
            $cups[$currentCup]['next'] = $afterExtract;
            $afterExtract = $cups[$newCup]['next'];
            $cups[$newCup]['next'] = $extract[0];
            $cups[$extract[2]]['next'] = $afterExtract;
            $currentCup = $cups[$currentCup]['next'];
        }

        return $cups;
    }
}

