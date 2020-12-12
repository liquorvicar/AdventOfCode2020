<?php

namespace AdventOfCode;

use AdventOfCode\App\Ferry;
use AdventOfCode\App\Waypoint;

class Answer12 extends Base
{

    public function one(array $input)
    {
        $directions = $this->trim($input);
        $ferry = array_reduce($directions, function (Ferry $ferry, $direction) {
            $instruction = substr($direction, 0, 1);
            $delta = (int)substr($direction, 1);
            switch ($instruction) {
                case 'W':
                    return $ferry->west($delta);
                case 'E':
                    return $ferry->east($delta);
                case 'N':
                    return $ferry->north($delta);
                case 'S':
                    return $ferry->south($delta);
                case 'L':
                    return $ferry->left($delta);
                case 'R':
                    return $ferry->right($delta);
                case 'F':
                    return $ferry->forward($delta);
            }
            throw new \Exception('Unknown direction ' . $direction);
        }, new Ferry());

        return abs($ferry->easting()) + abs($ferry->northing());
    }

    public function two(array $input)
    {
        $directions = $this->trim($input);
        $ferry = new Ferry();
        $waypoint = new Waypoint(-1, 10);
        foreach ($directions as $direction) {
            $instruction = substr($direction, 0, 1);
            $delta = (int)substr($direction, 1);
            switch ($instruction) {
                case 'W':
                    $waypoint = $waypoint->west($delta);
                    break;
                case 'E':
                    $waypoint = $waypoint->east($delta);
                    break;
                case 'N':
                    $waypoint = $waypoint->north($delta);
                    break;
                case 'S':
                    $waypoint = $waypoint->south($delta);
                    break;
                case 'L':
                    $waypoint = $waypoint->left($delta);
                    break;
                case 'R':
                    $waypoint = $waypoint->right($delta);
                    break;
                case 'F':
                    $ferry = $ferry->forwardToWaypoint($delta, $waypoint);
                    break;
                default:
                    throw new \Exception('Unknown direction ' . $direction);
            }
            $this->logger->debug('Command followed');
        }

        return abs($ferry->easting()) + abs($ferry->northing());
    }
}

