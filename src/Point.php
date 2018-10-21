<?php
/**
 * Created for coders-strike-back.
 *
 * File: Point.php
 * User: peterdekok
 * Date: 20/10/2018
 * Time: 18:25
 */

class Point implements PointableInterface {

    protected $x;
    protected $y;

    /**
     * Point constructor
     *
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y) {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * getPoint
     *
     * Pointless self loop. But it makes it a valid Pointable, which is handy in some cases.
     *
     * @return \Point
     */
    public function getPoint() : Point {
        return $this;
    }

    /**
     * x
     *
     * Returns the x component of this point
     *
     * @return int
     */
    public function x() : int {
        return $this->x;
    }

    /**
     * y
     *
     * Returns the y component of this point
     *
     * @return int
     */
    public function y() : int {
        return $this->y;
    }

    /**
     * update
     *
     * Update the coordinates of the point. This should only happen for movable items.
     *
     * @param int $x
     * @param int $y
     *
     * @return \Point
     */
    public function update(int $x, int $y) : Point {
        $this->x = $x;
        $this->y = $y;

        return $this;
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
     * @return float|int
     */
    public function distanceTo($point, int $pointY = null) : ?float {
        $distanceSquared = $this->distanceToSquared($point, $pointY);

        if ($distanceSquared < 0)
            return $distanceSquared;

        return $this->fastInvSqrt($distanceSquared);
    }

    /**
     * distanceToSquared
     *
     * Returns the squared distance between this point and the provided one.
     * This is half of a method returning the distance,
     * but as the squared distance is sometimes needed for further calculation I split it.
     *
     * @param \PointableInterface|int $point
     * @param int|null $pointY
     *
     * @return int
     */
    public function distanceToSquared($point, int $pointY = null) : ?int {
        if ($point instanceof PointableInterface)
            $point = $point->getPoint();

        if (is_int($point) && !is_null($pointY)) {
            $x2 = $point;
            $y2 = $pointY;
        } else if ($point instanceof Point) {
            $x2 = $point->x();
            $y2 = $point->y();
        } else {
            return -1;
        }

        $x1 = $this->x();
        $y1 = $this->y();

        $x = $x1 - $x2;
        $y = $y1 - $y2;

        return $x * $x + $y * $y;
    }

    /**
     * fastInvSqrt
     *
     * Fast square root approximation
     * Borrowed from itchyny/fastinvsqrt
     *
     * @author https://github.com/itchyny
     *
     * @param float|int $x
     *
     * @return float
     */
    protected final function fastInvSqrt($x) : float {
        $i = unpack('l', pack('f', $x))[1];
        $i = 0x5f3759df - ($i >> 1);
        $y = unpack('f', pack('l', $i))[1];

        return $y * (1.5 - 0.5 * $x * $y * $y);
    }
}
