<?php

namespace AdventOfCode;

class Answer05 extends Base
{

    public function one(array $input)
    {
        $boardingPasses = $input;

        return array_reduce($boardingPasses, function ($highest, $boardingPass) {
            $id = $this->getSeatId($boardingPass);

            return $id > $highest ? $id : $highest;
        }, 0);
    }

    public function two(array $input)
    {
        $boardingPasses = $input;

        $allIds = array_map(function ($boardingPass) {
            return $this->getSeatId($boardingPass);
        }, $boardingPasses);
        sort($allIds);
        $possibles = [];
        $prev = null;
        foreach ($allIds as $id) {
            if ($prev && ($id - $prev) === 2) {
                $possibles[] = ($id - 1);
            }
            $prev = $id;
        }

        $this->logger->debug('Possibles', $possibles);

        return reset($possibles);
    }

    public function getSeatCoords($boardingPass): array
    {
        $boardingPass = str_split($boardingPass);
        return [
            'row' => $this->lettersToBinary(64, array_slice($boardingPass, 0, 7), 'B'),
            'column' => $this->lettersToBinary(4, array_slice($boardingPass, 7), 'R'),
        ];
    }

    protected function lettersToBinary(float $digit, array $boardingPass, string $one): int
    {
        $number = 0;
        while ($digit >= 1) {
            $char = array_shift($boardingPass);
            if ($char === $one) {
                $number += $digit;
            }
            $digit = $digit / 2;
        }

        return $number;
    }

    public function getSeatId(string $boardingPass): int
    {
        $coords = $this->getSeatCoords($boardingPass);

        return ($coords['row'] * 8) + $coords['column'];
    }
}

