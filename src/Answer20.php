<?php

namespace AdventOfCode;

class Answer20 extends Base
{

    public function one(array $input)
    {
        $grid = $this->findGrid($input);
        $checksum = 1;
        $firstRow = reset($grid[0]);
        $checksum = $checksum * reset($firstRow) * end($firstRow);
        $lastRow = end($grid[0]);
        $checksum = $checksum * reset($lastRow) * end($lastRow);
        return $checksum;
    }

    public function two(array $input)
    {
        $grid = $this->findGrid($input);
        $grid = $grid[1];
        $grid = $this->stripBorders($grid);
        $image = $this->formImage($grid);
        $countMonsters = 0;
        $countSquares = $this->countAllSquares($image);
        $rotate = 0;
        $flip = false;
        while ($countMonsters === 0) {
            $countMonsters = $this->countMonsters($image);
            $image = $this->rotateTile($image);
            $rotate++;
            if ($rotate === 4) {
                if ($flip) {
                    break;
                }
                $image = $this->flipTile($image);
                $flip = true;
                $rotate = 0;
            }
        }
        
        return $countSquares - $countMonsters;
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
        $square = sqrt(count($tiles));

        foreach ($tiles as $tileId => $tile) {
            $remainingTiles = $tiles;
            unset($remainingTiles[$tileId]);
            $matchingGrid = $this->findMatchingGrid($tile, [[$tileId]], [], $remainingTiles, $square);
            if (!empty($matchingGrid)) {
                break;
            }
        }

        return $matchingGrid;
    }

    private function findMatchingGrid($tile, array $gridIds, array $grid, array $remainingTiles, int $squareSize)
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
                    if ($newCol > ($squareSize - 1)) {
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
                        $foundGrid = $this->findMatchingGrid($remainingTile, $newGridIds, $grid, $newRemainingTiles, $squareSize);
                        if (!empty($foundGrid)) {
                            $newGrid = $foundGrid[0];
                            if (count($newGrid) === $squareSize && count(end($newGrid)) === $squareSize) {
                                $grid = $foundGrid[1];
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

        return $foundMatch ? [$gridIds, $grid] : [];
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

    private function stripBorders($grid)
    {
        return array_map(function ($row) {
            return array_map(function ($tile) {
                $newTile = [];
                array_shift($tile);
                array_pop($tile);
                while (!empty($tile)) {
                    $row = array_shift($tile);
                    array_shift($row);
                    array_pop($row);
                    $newTile[] = $row;
                }
                return $newTile;
            }, $row);
        }, $grid);
    }

    private function formImage(array $grid)
    {
        return array_reduce($grid, function ($newGrid, $row) {
            foreach ($row[0] as $tileRowNum => $tileRow) {
                $newTileRow = array_reduce($row, function ($newTileRow, $tile) use ($tileRowNum) {
                    return array_merge($newTileRow, $tile[$tileRowNum]);
                }, []);
                $newGrid[] = $newTileRow;
            }
            return $newGrid;
        }, []);
    }

    private function countAllSquares(array $image)
    {
        return array_reduce($image, function ($count, $row) {
            $squares = array_filter($row, function ($bit) {
                return $bit === '#';
            });
            return $count + count($squares);
        }, 0);
    }

    public function countMonsters(array $image)
    {
        $seaMonster = [
            [0, 18],
            [1, 0],
            [1, 5],
            [1, 6],
            [1, 11],
            [1, 12],
            [1, 17],
            [1, 18],
            [1, 19],
            [2, 1],
            [2, 4],
            [2, 7],
            [2, 10],
            [2, 13],
            [2, 16],
        ];
        $count = 0;
        foreach ($image as $y => $row) {
            foreach ($row as $x => $dot) {
                $found = 1;
                foreach ($seaMonster as $vector) {
                    list($vectorY, $vectorX) = $vector;
                    $target = $image[$vectorY + $y][$vectorX + $x] ?? '.';
                    if ($target !== '#') {
                        $found = 0;
                        break;
                    }
                }
                $count+= $found;
            }
        }
        return $count * count($seaMonster);
    }
}

