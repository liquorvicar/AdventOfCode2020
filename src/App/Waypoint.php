<?php

namespace AdventOfCode\App;

class Waypoint extends CompassMovable
{

    public function right(int $degrees): self
    {
        $waypoint = clone $this;
        if ($degrees === 270) {
            return $waypoint->left(90);
        }

        if ($degrees === 180) {
            $waypoint->easting = $waypoint->easting * -1;
            $waypoint->northing = $waypoint->northing * -1;
        } else {
            $waypoint->northing = $this->easting;
            $waypoint->easting = $this->northing;
            if ($waypoint->northing >= 0 && $waypoint->easting > 0) {
                $waypoint->easting = $waypoint->easting * -1;
            } elseif ($waypoint->northing > 0 && $waypoint->easting <= 0) {
                $waypoint->easting = $waypoint->easting * -1;
            } elseif ($waypoint->northing < 0 && $waypoint->easting <= 0) {
                $waypoint->easting = $waypoint->easting * -1;
            } else {
                $waypoint->easting = $waypoint->easting * -1;
            }
        }

        return $waypoint;
    }

    public function left(int $degrees): self
    {
        $waypoint = clone $this;
        if ($degrees === 270) {
            return $waypoint->right(90);
        }

        if ($degrees === 180) {
            $waypoint->easting = $waypoint->easting * -1;
            $waypoint->northing = $waypoint->northing * -1;
        } else {
            $waypoint->northing = $this->easting;
            $waypoint->easting = $this->northing;
            if ($this->northing > 0 && $this->easting >= 0) {
                $waypoint->northing = $waypoint->northing * -1;
            } elseif ($this->northing >= 0 && $this->easting <= 0) {
                $waypoint->northing = $waypoint->northing * -1;
            } elseif ($this->northing < 0 && $this->easting <= 0) {
                $waypoint->northing = $waypoint->northing * -1;
            } else {
                $waypoint->northing = $waypoint->northing * -1;
            }
        }

        return $waypoint;
    }
}
