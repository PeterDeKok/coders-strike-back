<?php
/**
 * Created for coders-strike-back.
 *
 * File: Circle.php
 * User: peterdekok
 * Date: 21/10/2018
 * Time: 13:30
 */

trait Circle {

    use Sizable;
    protected $radius;

    /**
     * getRadius
     *
     * Returns the radius of this object
     *
     * @return int
     */
    public function getRadius() : int {
        return $this->radius;
    }

    /**
     * collision
     *
     * Returns whether the radii of this and another object are overlapping
     *
     * @param \SizableInterface $sizable
     *
     * @return bool
     */
    public function collision(SizableInterface $sizable) : bool {
        // TODO Implement this
        return true;
    }

    /**
     * inside
     *
     * Returns whether the provided point is inside this sizable
     *
     * First trying to eliminate the obvious, to make it more performing.
     *
     * @param \PointableInterface $pointable
     *
     * @return bool
     */
    public function inside(PointableInterface $pointable) : bool {
        // Test a square (exactly containing circle) first (x component)
        if (($dx = abs($pointable->getPoint()->x() - $this->getPoint()->x())) > $this->getRadius())
            return false;

        // Test a square (exactly containing circle) first (y component)
        if (($dy = abs($pointable->getPoint()->y() - $this->getPoint()->y())) > $this->getRadius())
            return false;

        // Test a diamond (diamond exactly in circle) next
        if ($dx + $dy <= $this->getRadius())
            return true;

        // Fall back to pythagoras for the remaining (small) segments.
        return ($dx * $dx + $dy * $dy <= $this->getRadius() * $this->getRadius());
    }
}
