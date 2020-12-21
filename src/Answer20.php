<?php

namespace AdventOfCode;

class Answer20 extends Base
{

    public function one(array $input)
    {
    }

    public function two(array $input)
    {
    }

    public function parseInput(array $input): array
    {
        $tileId = 0;
        $tiles = [];
        $tile = [];
        while (!empty($input)) {
            $line = array_shift($input);
            $line = trim($line);
            if (!$line) {
                continue;
            } elseif (substr($line, 0, 4) === 'Tile') {
                if (!empty($tile)) {
                    $tiles[$tileId] = $tile;
                    $tile = [];
                }
                $tileId = (int)str_replace('Tile ', '', trim($line, ':'));
            } else {
                $tile[] = str_split($line);
            }
        }
        if (!empty($tile)) {
            $tiles[$tileId] = $tile;
        }

        return $tiles;
    }

    public function findGrid(array $input): array
    {
        $tiles = $this->parseInput($input);
        $matchingGrid = [];

        foreach ($tiles as $tileId => $tile) {
            $remainingTiles = $tiles;
            unset($remainingTiles[$tileId]);
            $matchingGrid = $this->findMatchingGrid($tile, [[$tileId]], [], $remainingTiles);
            if (!empty($matchingGrid)) {
                break;
            }
        }

        return $matchingGrid;
    }

    private function findMatchingGrid($tile, array $gridIds, array $grid, array $remainingTiles)
    {
        $currentRow = max(array_keys($gridIds));
        $row = $gridIds[$currentRow];
        $currentCol = max(array_keys($row));
        $foundMatch = false;
        $flipped = false;
        do {
            for ($i = 0; $i < 4; $i++) {
                $matches = true;
                if ($currentRow > 0) {
                    $matches = $matches && $this->matchesTop($tile, $grid[$currentRow - 1][$currentCol]);
                }
                if ($currentCol > 0) {
                    $matches = $matches && $this->matchesLeft($tile, $grid[$currentRow][$currentCol - 1]);
                }
                if ($matches) {
                    $this->logger->debug('Found match', ['tiles' => count($gridIds)]);
                    $grid[$currentRow][$currentCol] = $tile;
                    $newCol = $currentCol + 1;
                    $newRow = $currentRow;
                    if ($newCol > 2) {
                        $newCol = 0;
                        $newRow = $currentRow + 1;
                    }
                    if (empty($remainingTiles)) {
                        $foundMatch = true;
                        break 2;
                    }
                    foreach ($remainingTiles as $remainingTileId => $remainingTile) {
                        $newGridIds = $gridIds;
                        $newGridIds[$newRow][$newCol] = $remainingTileId;
                        $newRemainingTiles = $remainingTiles;
                        unset($newRemainingTiles[$remainingTileId]);
                        $newGrid = $this->findMatchingGrid($remainingTile, $newGridIds, $grid, $newRemainingTiles);
                        if (!empty($newGrid)) {
                            if (count($newGrid) === 3 && count($newGrid[2]) === 3) {
                                $gridIds = $newGrid;
                                $foundMatch = true;
                                break 3;
                            }
                        }
                    }
                }
                $tile = $this->rotateTile($tile);
            }
            $flipped = !$flipped;
            $tile = $this->flipTile($tile);
        } while ($flipped === true);

        return $foundMatch ? $gridIds : [];
    }

    private function matchesTop($tile, $tileAbove): bool
    {
        return $tile[0] === end($tileAbove);
    }

    private function matchesLeft($tile, $tileLeft): bool
    {
        foreach ($tile as $rowNumber => $row) {
            if ($row[0] !== end($tileLeft[$rowNumber])) {
                return false;
            }
        }
        return true;
    }

    private function rotateTile($tile)
    {
        $newTile = [];
        $col = count($tile[0]) - 1;
        foreach ($tile as $rowNumber => $row) {
            foreach ($row as $colNumber => $char) {
                $newTile[$colNumber][$col] = $char;
            }
            $col--;
        }
        return array_map(function ($row) {
            ksort($row);
            return $row;
        }, $newTile);
    }

    private function flipTile(array $tile): array
    {
        $newTile = [];
        $rows = count($tile) - 1;
        foreach ($tile as $rowNumber => $row) {
            $newTile[$rows - $rowNumber] = $row;
        }
        ksort($newTile);
        return $newTile;
    }
}

