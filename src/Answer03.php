<?php

namespace AdventOfCode;

use AdventOfCode\App\GridPosition;

class Answer03 extends Base
{

    public function one(array $input)
    {
        $grid = array_filter($input);

        return $this->countTrees($grid, 3, 1);
    }

    public function two(array $input)
    {
        $grid = array_filter($input);
        $result = 1;
        $deltas = [
            ['x' => 1, 'y' => 1],
            ['x' => 3, 'y' => 1],
            ['x' => 5, 'y' => 1],
            ['x' => 7, 'y' => 1],
            ['x' => 1, 'y' => 2],
        ];
        foreach ($deltas as $delta) {
            $trees = $this->countTrees($grid, $delta['x'], $delta['y']);
            $this->logger->debug('Found trees', ['x' => $delta['x'], 'y' => $delta['y'], 'trees' => $trees]);
            $result = $result * $trees;
        }

        return $result;
    }

    private function isTree(array $grid, GridPosition $position): bool
    {
        if ($position->getY() > (count($grid) - 1)) {
            return false;
        }
        $row = str_split(trim($grid[$position->getY()]));
        $xPos = $position->getX() % count($row);

        return $row[$xPos] === '#';
    }

    /**
     * @param array $grid
     * @return int
     */
    protected function countTrees(array $grid, int $deltaX, int $deltaY): int
    {
        $position = new GridPosition(0, 0);

        $trees = 0;
        $position = $position->move($deltaX, $deltaY);
        while ($position->getY() < count($grid)) {
            if ($this->isTree($grid, $position)) {
                $trees++;
            }
            $position = $position->move($deltaX, $deltaY);
        }

        return $trees;
    }
}

