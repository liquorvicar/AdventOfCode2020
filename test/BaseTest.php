<?php

namespace AdventOfCode;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

abstract class BaseTest extends TestCase
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function setUp(): void
    {
        parent::setUp();
        $this->logger = new Logger('AoC Test logger');
    }

}