<?php

namespace AdventOfCode\App;

class CompassMovable
{
    /**
     * @var int
     */
    protected $easting;
    /**
     * @var int
     */
    protected $northing;

    public function __construct(int $northing = 0, int $easting = 0)
    {
        $this->northing = $northing;
        $this->easting = $easting;
    }

    public function northing(): int
    {
        return $this->northing;
    }

    public function easting(): int
    {
        return $this->easting;
    }

    public function west(int $delta): self
    {
        $ferry = clone $this;
        $ferry->easting -= $delta;

        return $ferry;
    }

    public function east(int $delta): self
    {
        $ferry = clone $this;
        $ferry->easting += $delta;

        return $ferry;
    }

    public function south(int $delta): self
    {
        $ferry = clone $this;
        $ferry->northing += $delta;

        return $ferry;
    }

    public function north(int $delta): self
    {
        $ferry = clone $this;
        $ferry->northing -= $delta;

        return $ferry;
    }
}