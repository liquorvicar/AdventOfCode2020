<?php

namespace AdventOfCode;

class Answer25 extends Base
{

    public function one(array $input)
    {
        $publicKeys = $this->numbers($input);
        $loops = array_map(function ($publicKey) {
            return $this->getLoopSize($publicKey);
        }, $publicKeys);

        return $this->getEncryptionKey($publicKeys[0], $loops[1]);
    }

    public function two(array $input)
    {
    }

    public function getLoopSize($publicKey): int
    {
        $value = 1;
        $subject = 7;
        $loop = 0;
        while ($value !== $publicKey) {
            $value = $value * $subject;
            $value = ($value % 20201227);
            $loop++;
        }

        return $loop;
    }

    public function getEncryptionKey(int $publicKey, int $loops)
    {
        $value = 1;
        for ($i = 1; $i <= $loops; $i++) {
            $value = $value * $publicKey;
            $value = ($value % 20201227);
        }
        return $value;
    }
}

