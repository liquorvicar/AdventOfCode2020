<?php

namespace AdventOfCode;

class Answer11 extends Base
{

    public function one(array $input)
    {
        $grid = $this->parseGrid($input);
        $counter = 'countOccupiedAdjacent';
        $tolerance = 4;
        $stable = false;
        while (!$stable) {
            $newGrid = $this->getNewGrid($grid, $counter, $tolerance);
            if ($newGrid === $grid) {
                $stable = true;
            }
            $grid = $newGrid;
        }

        return $this->countAllOccupied($grid);
    }

    public function two(array $input)
    {
        $grid = $this->parseGrid($input);
        $counter = 'countVisibleOccupied';
        $tolerance = 5;
        $stable = false;
        while (!$stable) {
            $newGrid = $this->getNewGrid($grid, $counter, $tolerance);
            if ($newGrid === $grid) {
                $stable = true;
            }
            $grid = $newGrid;
        }

        return $this->countAllOccupied($grid);
    }

    public function parseGrid(array $grid)
    {
        return array_map(function ($row) {
            return str_split(trim($row));
        }, $grid);
    }

    public function toggleSeat(int $row, int $col, array $grid, $counter, $tolerance): bool
    {
        $current = $grid[$row][$col];
        if ($current === '.') {
            return false;
        }
        $occupiedAdjacent = $this->$counter($row, $col, $grid);
        if ($current === 'L' && $occupiedAdjacent === 0) {
            return true;
        } elseif ($current === '#' && $occupiedAdjacent >= $tolerance) {
            return true;
        }
        return false;
    }

    public function countVisibleOccupied(int $row, int $col, array $grid)
    {
        $vectors = [
            [-1, 0],
            [-1, 1],
            [0, 1],
            [1, 1],
            [1, 0],
            [1, -1],
            [0, -1],
            [-1, -1],
        ];
        $count = 0;
        foreach ($vectors as $vector) {
            $firstVisible = $this->findFirstVisible($row, $col, $grid, $vector);
            if ($firstVisible === '#') {
                $count++;
            }
        }
        return $count;
    }

    private function countOccupiedAdjacent(int $row, int $col, array $grid)
    {
        $occupied = 0;
        $occupied+= ($grid[$row - 1][$col] ?? '.') === '#';
        $occupied+= ($grid[$row - 1][$col + 1] ?? '.') === '#';
        $occupied+= ($grid[$row][$col + 1] ?? '.') === '#';
        $occupied+= ($grid[$row + 1][$col + 1] ?? '.') === '#';
        $occupied+= ($grid[$row + 1][$col] ?? '.') === '#';
        $occupied+= ($grid[$row + 1][$col - 1] ?? '.') === '#';
        $occupied+= ($grid[$row][$col - 1] ?? '.') === '#';
        $occupied+= ($grid[$row - 1][$col - 1] ?? '.') === '#';

        return $occupied;
    }

    private function countAllOccupied(array $grid)
    {
        return array_reduce($grid, function ($count, $row) {
            $count+= count(array_filter($row, function ($seat) {
                return $seat === '#';
            }));

            return $count;
        }, 0);
    }

    public function getNewGrid($oldGrid, $counter, $tolerance): array
    {
        $newGrid = $oldGrid;
        foreach ($oldGrid as $row => $rowData) {
            foreach ($rowData as $col => $seat) {
                $toggle = $this->toggleSeat($row, $col, $oldGrid, $counter, $tolerance);
                if ($toggle) {
                    $newSeat = $seat === 'L' ? '#' : 'L';
                    $newGrid[$row][$col] = $newSeat;
                }
            }
        }

        return $newGrid;
    }

    private function findFirstVisible(int $row, int $col, array $grid, array $vector)
    {
        $found = false;
        $seat = 'L';
        while (!$found) {
            $row+= $vector[0];
            $col+= $vector[1];
            $seat = $grid[$row][$col] ?? 'L';
            $found = $seat !== '.';
        }

        return $seat;
    }
}

