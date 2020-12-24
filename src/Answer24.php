<?php

namespace AdventOfCode;

class Answer24 extends Base
{

    public function one(array $input)
    {
        $floor = $this->getInitialFloor($input);

        return $this->countTiles($floor);
    }

    public function two(array $input)
    {
        return $this->countTilesAfterXDays($input, 100);
    }

    public function findTile($direction, $x = 0, $y = 0): array
    {
        foreach ($direction as $point) {
            if ($point === 'nw') {
                if (abs($y % 2) === 0) {
                    $x -= 1;
                }
                $y -= 1;
            } elseif ($point === 'ne') {
                if (abs($y % 2) === 1) {
                    $x += 1;
                }
                $y -= 1;
            } elseif ($point === 'sw') {
                if (abs($y % 2) === 0) {
                    $x -= 1;
                }
                $y += 1;
            } elseif ($point === 'se') {
                if (abs($y % 2) === 1) {
                    $x += 1;
                }
                $y += 1;
            } elseif ($point === 'w') {
                $x -= 1;
            } elseif ($point === 'e') {
                $x += 1;
            } else {
                $this->logger->debug('Unknown compass point', [$point]);
            }
        }
        return array($x, $y);
    }

    protected function getInitialFloor(array $input): array
    {
        $directions = [];
        while (!empty($input)) {
            $line = trim(array_shift($input));
            if (!$line) {
                continue;
            }
            $direction = [];
            $line = str_split($line);
            while (!empty($line)) {
                $point = array_shift($line);
                if ($point === 'n' || $point === 's') {
                    $point .= array_shift($line);
                }
                $direction[] = $point;
            }
            $directions[] = $direction;
        }
        $floor = [];
        foreach ($directions as $direction) {
            list($x, $y) = $this->findTile($direction);
            if (!isset($floor[$y])) {
                $floor[$y] = [];
            }
            if (!isset($floor[$y][$x])) {
                $floor[$y][$x] = true;
            } else {
                $floor[$y][$x] = !$floor[$y][$x];
            }
        }
        return $floor;
    }

    public function countTilesAfterXDays($input, $days)
    {
        $floor = $this->getInitialFloor($input);
        for ($i = 1; $i <= $days; $i++) {
            $this->logger->debug('Flipping day', [$i]);
            ksort($floor);
            $lowestRow = min(array_keys($floor));
            $highestRow = max(array_keys($floor));
            $lowestCol = array_reduce($floor, function ($lowest, $row) {
                if (min(array_keys($row)) < $lowest) {
                    return min(array_keys($row));
                }
                return $lowest;
            }, 0);
            $highestCol = array_reduce($floor, function ($highest, $row) {
                if (max(array_keys($row)) > $highest) {
                    return max(array_keys($row));
                }
                return $highest;
            }, 0);
            $newFloor = $floor;
            for ($y = ($lowestRow - 1); $y <= ($highestRow + 1); $y++) {
                for ($x = ($lowestCol - 1); $x <= ($highestCol + 1); $x++) {
                    $current = $floor[$y][$x] ?? false;
                    $blackNeighbours = $this->countNeighbours($floor, $x, $y);
                    $new = $current;
                    if ($current && ($blackNeighbours === 0 || $blackNeighbours > 2)) {
                        $new = false;
                    } elseif (!$current && $blackNeighbours === 2) {
                        $new = true;
                    }
                    if (!isset($newFloor[$y])) {
                        $newFloor[$y] = [];
                    }
                    $newFloor[$y][$x] = $new;
                }
            }
            $floor = $newFloor;
        }

        return $this->countTiles($floor);
    }

    private function countTiles(array $floor)
    {
        return array_reduce($floor, function ($sum, $row) {
            return $sum + count(array_filter($row));
        }, 0);
    }

    private function countNeighbours(array $floor, int $x, int $y)
    {
        $neighbours = ['nw', 'ne', 'e', 'se', 'sw', 'w',];
        $count = 0;
        foreach ($neighbours as $neighbour) {
            list($neighbourX, $neighbourY) = $this->findTile([$neighbour], $x, $y);
            if (isset($floor[$neighbourY][$neighbourX]) && $floor[$neighbourY][$neighbourX]) {
                $count++;
            }
        }

        return $count;
    }
}

