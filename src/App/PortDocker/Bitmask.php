<?php

namespace AdventOfCode\App\PortDocker;

class Bitmask
{
    /** @var array */
    private $mask;

    public function __construct(string $maskString)
    {
        $this->mask = str_split(strtolower($maskString));
    }

    public function apply(int $decimal): int
    {
        $intArray = [];
        $index = 2 ** 35;
        while ($index >= 1) {
            if ($decimal >= $index) {
                $intArray[] = 1;
                $decimal -= $index;
            } else {
                $intArray[] = 0;
            }
            $index = $index / 2;
        }
        $newIntArray = [];
        foreach ($this->mask as $i => $mask) {
            $newIntArray[$i] = $intArray[$i];
            if ($mask !== 'x' && $mask !== $intArray[$i]) {
                $newIntArray[$i] = $mask;
            }
        }
        $index = 2 ** 35;
        $decimal = 0;
        while ($index >= 1) {
            $value = array_shift($newIntArray);
            if ($value) {
                $decimal+= $index;
            }
            $index = $index / 2;
        }

        return $decimal;
    }
}