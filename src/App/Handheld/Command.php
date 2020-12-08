<?php


namespace AdventOfCode\App\Handheld;


interface Command
{
    public function execute(Registry $registry): Registry;

    public function repair(): Command;
}