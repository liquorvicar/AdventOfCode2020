<?php

namespace AdventOfCode;

class Answer17 extends Base
{

    public function one(array $input)
    {
        $input = $this->trim($input);
        $grid[0] = [];
        foreach ($input as $line) {
            $grid[0][] = str_split($line);
        }

        for ($i = 1; $i <= 6; $i++) {
            $grid = $this->expandGrid($grid);
            $newGrid = $grid;
            foreach ($grid as $z => $plane) {
                foreach ($plane as $y => $row) {
                    foreach ($row as $x => $cube) {
                        $newGrid[$z][$y][$x] = $this->newState($x, $y, $z, $grid);
                    }
                }
            }
            $grid = $newGrid;
        }

        return $this->countGrid($grid);
    }

    public function two(array $input, int $iterations = 6)
    {
        $input = $this->trim($input);
        $grid[0] = [0 => []];
        foreach ($input as $line) {
            $grid[0][0][] = str_split($line);
        }

        for ($i = 1; $i <= $iterations; $i++) {
            $grid = array_map(function ($timeSlice) {
               return $this->expandGrid($timeSlice);
            }, $grid);
            $blankSlice = array_map(function ($plane) {
                return array_map(function ($row) {
                    $rowLength = count($row);
                    return array_fill(0, $rowLength, '.');
                }, $plane);
            }, reset($grid));
            array_unshift($grid, $blankSlice);
            $grid[] = $blankSlice;
            $newGrid = $grid;
            foreach ($grid as $w => $timeSlice) {
                foreach ($timeSlice as $z => $plane) {
                    foreach ($plane as $y => $row) {
                        foreach ($row as $x => $cube) {
                            $newGrid[$w][$z][$y][$x] = $this->newState4d($x, $y, $z, $w, $grid);
                        }
                    }
                }
            }
            $grid = $newGrid;
        }

        return array_reduce($grid, function ($sum, $timeSlice) {
            return $sum + $this->countGrid($timeSlice);
        }, 0);
    }

    private function newState(int $x, int $y, int $z, array $grid)
    {
        $activeNeighbours = $this->countActive($x, $y, $z, $grid);
        $currentState = $grid[$z][$y][$x];
        if ($currentState === '#') {
            return $activeNeighbours === 2 || $activeNeighbours === 3 ? '#' : '.';
        } else {
            return $activeNeighbours === 3 ? '#' : '.';
        }
    }

    private function newState4d(int $x, int $y, int $z, int $w, array $grid)
    {
        $activeNeighbours = $this->countActive4d($x, $y, $z, $w, $grid);
        $currentState = $grid[$w][$z][$y][$x];
        if ($currentState === '#') {
            return $activeNeighbours === 2 || $activeNeighbours === 3 ? '#' : '.';
        } else {
            return $activeNeighbours === 3 ? '#' : '.';
        }
    }

    private function countActive(int $x, int $y, int $z, array $grid)
    {
        $count = 0;
        for ($targetX = $x - 1; $targetX <= $x +1; $targetX++) {
            for ($targetY = $y - 1; $targetY <= $y +1; $targetY++) {
                for ($targetZ = $z - 1; $targetZ <= $z + 1; $targetZ++) {
                    if ($targetX === $x && $targetY === $y && $targetZ === $z) {
                        continue;
                    }
                    if (isset($grid[$targetZ][$targetY][$targetX]) && $grid[$targetZ][$targetY][$targetX] === '#') {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    private function countActive4d(int $x, int $y, int $z, int $w, array $grid)
    {
        $count = 0;
        for ($targetX = $x - 1; $targetX <= $x +1; $targetX++) {
            for ($targetY = $y - 1; $targetY <= $y +1; $targetY++) {
                for ($targetZ = $z - 1; $targetZ <= $z + 1; $targetZ++) {
                    for ($targetW = $w - 1; $targetW <= $w + 1; $targetW++) {
                        if ($targetX === $x && $targetY === $y && $targetZ === $z && $targetW === $w) {
                            continue;
                        }
                        if (isset($grid[$targetW][$targetZ][$targetY][$targetX]) && $grid[$targetW][$targetZ][$targetY][$targetX] === '#') {
                            $count++;
                        }
                    }
                }
            }
        }

        return $count;
    }

    /**
     * @param array $grid
     * @return array
     */
    protected function expandGrid(array $grid): array
    {
        $grid = array_map(function ($plane) {
            $plane = array_map(function ($row) {
                array_unshift($row, '.');
                $row[] = '.';
                return $row;
            }, $plane);
            $rowLength = count(reset($plane));
            $blankRow = array_fill(0, $rowLength, '.');
            array_unshift($plane, $blankRow);
            $plane[] = $blankRow;
            return $plane;
        }, $grid);
        $emptyPlane = reset($grid);
        $emptyPlane = array_map(function ($row) {
            $rowLength = count($row);
            return array_fill(0, $rowLength, '.');
        }, $emptyPlane);
        array_unshift($grid, $emptyPlane);
        $grid[] = $emptyPlane;
        return $grid;
    }

    /**
     * @param $grid
     * @param $newGrid
     * @return mixed
     */
    protected function mapGrid($grid)
    {
        $newGrid = $grid;
        foreach ($grid as $z => $plane) {
            foreach ($plane as $y => $row) {
                foreach ($row as $x => $cube) {
                    $newGrid[$z][$y][$x] = $this->newState($x, $y, $z, $grid);
                }
            }
        }
        return $newGrid;
    }

    /**
     * @param array $grid
     * @return mixed
     */
    protected function countGrid(array $grid)
    {
        return array_reduce($grid, function ($sum, $plane) {
            return $sum + array_reduce($plane, function ($sum, $row) {
                    return $sum + count(array_filter($row, function ($cube) {
                            return $cube === '#';
                        }));
                }, 0);
        }, 0);
    }
}

