<?php
/**
 * Created for coders-strike-back.
 *
 * File: Pointable.php
 * User: peterdekok
 * Date: 20/10/2018
 * Time: 18:45
 */

interface PointableInterface {

    /**
     * getPoint
     *
     * Returns the Point associated with this object
     *
     * @return \Point
     */
    public function getPoint() : ?Point;

    /**
     * distanceTo
     *
     * Returns the distance between this point and the provided one.
     * Note, this method uses an approximation for the square root needed.
     *
     * @param \PointableInterface $point
     *
     * @return float
     */
    public function distanceTo(PointableInterface $point) : ?float;

    /**
     * distanceToSquared
     *
     * Returns the squared distance between this pointable and the provided one.
     * This is half of a method returning the distance,
     * but as the squared distance is sometimes needed for further calculation I split it.
     *
     * @param \PointableInterface $point
     *
     * @return int
     */
    public function distanceToSquared(PointableInterface $point) : ?int;
}
