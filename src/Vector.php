<?php
/**
 * Created for coders-strike-back.
 *
 * File: Vector.php
 * User: peterdekok
 * Date: 21/10/2018
 * Time: 12:05
 */

class Vector {

    protected $pointA;
    protected $pointB;
    protected $x;
    protected $y;

    public function __construct(Point $pointA, Point $pointB) {
        $this->pointA = $pointA;
        $this->pointB = $pointB;
        $this->x = $pointB->x() - $pointA->x();
        $this->y = $pointB->y() - $pointA->y();
    }

    /**
     * getPointA
     *
     * Returns the start point of the vector
     *
     * @return \Point
     */
    public function getPointA() : Point {
        return $this->pointA;
    }

    /**
     * getPointB
     *
     * Returns the end point of the vector
     *
     * @return \Point
     */
    public function getPointB() : Point {
        return $this->pointB;
    }

    /**
     * x
     *
     * Returns the x component of this vector
     *
     * @return int
     */
    public function x() : int {
        return $this->x;
    }

    /**
     * y
     *
     * Returns the y component of this vector
     *
     * @return int
     */
    public function y() : int {
        return $this->y;
    }

    /**
     * angle
     *
     * Return the angle between this point and 2 others,
     *
     * @param \Vector $other
     *
     * @return int
     */
    public function angle(Vector $other) {
        $dot = ($this->x() * $other->x() + $this->y() * $other->y()); // dot product
        $crs = ($this->x() * $other->x() - $this->y() * $other->y()); // cross product

        $alpha = atan2($crs, $dot);

        return (int) floor($alpha * 180. / M_PI + 0.5);
    }
}
