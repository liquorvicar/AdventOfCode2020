<?php

namespace AdventOfCode\App;

class Ferry extends CompassMovable
{
    /**
     * @var string
     */
    private $heading;

    private static $headings = ['N', 'E', 'S', 'W'];

    public function __construct(string $heading = 'E', int $northing = 0, int $easting = 0)
    {
        parent::__construct($northing, $easting);

        $this->heading = $heading;
    }

    public function heading(): string
    {
        return $this->heading;
    }

    public function left(int $degrees): Ferry
    {
        $ferry = clone $this;
        $current = array_search($ferry->heading, self::$headings);
        $new = ($current - ($degrees / 90) + 4) % 4;
        $ferry->heading = self::$headings[$new];

        return $ferry;
    }

    public function right(int $degrees): Ferry
    {
        $ferry = clone $this;
        $current = array_search($ferry->heading, self::$headings);
        $new = ($current + ($degrees / 90)) % 4;
        $ferry->heading = self::$headings[$new];

        return $ferry;
    }

    public function forward(int $delta): Ferry
    {
        $ferry = clone $this;
        switch ($this->heading) {
            case 'W':
                return $ferry->west($delta);
            case 'E':
                return $ferry->east($delta);
            case 'N':
                return $ferry->north($delta);
            case 'S':
                return $ferry->south($delta);
        }
        return $ferry;
    }

    public function forwardToWaypoint(int $times, Waypoint $waypoint): self
    {
        $ferry = clone $this;
        for ($i = 0; $i < $times; $i++) {
            $ferry = $ferry->south($waypoint->northing)
                ->east($waypoint->easting)
            ;
        }

        return $ferry;
    }
}