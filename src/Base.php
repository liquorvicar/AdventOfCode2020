<?php

namespace AdventOfCode;

use Psr\Log\LoggerInterface;

abstract class Base
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    abstract public function one(Array $input);

    abstract public function two(Array $input);

    protected function numbers(array $input): array
    {
        return array_filter(array_map(function ($value) {
            return (int)$value;
        }, $input));
    }

    public function trim(array $input): array
    {
        return array_filter($input, function ($line) {
            return trim($line);
        });
    }
}