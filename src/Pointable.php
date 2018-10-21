<?php
/**
 * Created for coders-strike-back.
 *
 * File: Pointable.php
 * User: peterdekok
 * Date: 20/10/2018
 * Time: 23:34
 */

trait Pointable {

    /** @var Point $point */
    protected $point = null;

    /**
     * getPoint
     *
     * Returns the Point associated with this object
     *
     * @return \Point
     */
    public function getPoint() : ?Point {
        return $this->point;
    }

    /**
     * distanceTo
     *
     * Returns the distance between this point and the provided one.
     * Note, this method uses an approximation for the square root needed.
     *
     * @param \PointableInterface|int $point
     * @param int|null $pointY
     *
     * @return float|null
     */
    public function distanceTo($point, int $pointY = null) : ?float {
        if (is_null($this->getPoint()))
            return null;

        return $this->getPoint()->distanceTo($point, $pointY);
    }

    /**
     * distanceToSquared
     *
     * Returns the squared distance between this pointable and the provided one.
     * This is half of a method returning the distance,
     * but as the squared distance is sometimes needed for further calculation I split it.
     *
     * @param \PointableInterface|int $point
     * @param int|null $pointY
     *
     * @return int|null
     */
    public function distanceToSquared($point, int $pointY = null) : ?int {
        if (is_null($this->getPoint()))
            return null;

        return $this->getPoint()->distanceToSquared($point, $pointY);
    }
}
