<?php

namespace AdventOfCode;

use AdventOfCode\App\PortDocker\Bitmask;
use AdventOfCode\App\PortDocker\Value;

class Answer14 extends Base
{

    public function one(array $input)
    {
        $program = $this->trim($input);
        $registry = [];
        $mask = null;

        foreach ($program as $line) {
            $matches = [];
            if (preg_match('/^mask = ([X10]+)$/', $line, $matches)) {
                $mask = new Bitmask($matches[1]);
            } else {
                preg_match('/^mem\[([0-9]+)\] = ([0-9]+)$/', $line, $matches);
                $index = (int)$matches[1];
                $value = new Value((int)$matches[2]);
                $registry[$index] = $value->apply($mask)->decimal();
            }
        }

        return array_sum(array_values($registry));
    }

    public function two(array $input)
    {
        $program = $this->trim($input);
        $registry = [];
        $mask = null;

        foreach ($program as $line) {
            $matches = [];
            if (preg_match('/^mask = ([X10]+)$/', $line, $matches)) {
                $mask = $matches[1];
            } else {
                preg_match('/^mem\[([0-9]+)\] = ([0-9]+)$/', $line, $matches);
                $index = (int)$matches[1];
                $indexes = $this->findAffectedAddresses($index, $mask);
                $value = (int)$matches[2];
                foreach ($indexes as $address) {
                    $registry[$address] = $value;
                }
            }
        }

        return array_sum(array_values($registry));
    }

    public function findAffectedAddresses(int $address, string $mask): array
    {
        $mask = array_map(function ($bit) {
            return $bit === 'x' ? $bit : (int)$bit;
        }, str_split(strtolower($mask)));
        $intArray = [];
        $index = 2 ** 35;
        while ($index >= 1) {
            if ($address >= $index) {
                $intArray[] = 1;
                $address -= $index;
            } else {
                $intArray[] = 0;
            }
            $index = $index / 2;
        }
        $maskedAddress = [];
        foreach ($mask as $i => $bit) {
            if ($bit === 'x' || $bit === 1) {
                $maskedAddress[$i] = $bit;
            } else {
                $maskedAddress[$i] = $intArray[$i];
            }
        }
        $addresses = [$maskedAddress];
        $appliedMask = false;
        while (!$appliedMask) {
            $firstMask = array_search('x', $addresses[0], true);
            if ($firstMask === false) {
                break;
            }
            $newAddresses = [];
            foreach ($addresses as $address) {
                $setOne = $address;
                $setOne[$firstMask] = 1;
                $newAddresses[] = $setOne;
                $setZero = $address;
                $setZero[$firstMask] = 0;
                $newAddresses[] = $setZero;
            }
            $addresses = $newAddresses;
        }

        $addresses = array_map(function ($address) {
            return $this->arrayToInt($address);
        }, $addresses);
        sort($addresses);

        return $addresses;
    }

    private function arrayToInt(array $newIntArray)
    {
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

