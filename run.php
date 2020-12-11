<?php

require_once 'vendor/autoload.php';

ini_set('memory_limit', '3072M');

$options = getopt('p:', ['day:']);

$day = (int)$options['day'];
$inputFilename = sprintf('./input/%02d.txt', $day);

if (!file_exists($inputFilename)) {
    throw new Exception('Cannot find input file.');
}

$input = file($inputFilename);

$logger = new Monolog\Logger('Advent of Code challenge');
$logger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::DEBUG));
$class = sprintf('AdventOfCode\Answer%02d', $day);
$answer = new $class($logger);

if (isset($options['p']) && $options['p'] === 'two') {
    echo $answer->two($input);
} else {
    echo $answer->one($input);
}
echo "\n";
