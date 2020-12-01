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

}