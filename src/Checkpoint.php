<?php
/**
 * Created for coders-strike-back.
 *
 * File: Checkpoint.php
 * User: peterdekok
 * Date: 20/10/2018
 * Time: 17:51
 */

class Checkpoint implements PointableInterface {

    use Pointable;
    protected $radius = 600;
    protected $hits   = 0;

    /**
     * Checkpoint constructor.
     *
     * @param \PointableInterface|int $point
     * @param int|null $pointY
     *
     * @throws \Exception
     */
    public function __construct($point, int $pointY = null) {
        if (is_int($point) && !is_null($pointY))
            $this->point = new Point($point, $pointY);
        else if (($point instanceof PointableInterface) && !is_null($point->getPoint()))
            $this->point = $point->getPoint();
        else
            throw new \Exception('Cannot initialize checkpoint without valid point');
    }

    /**
     * hit
     *
     * Increments the total amount of hits this checkpoint has received
     *
     * @return int
     */
    public function hit() : int {
        $this->hits++;

        return $this->getHits();
    }

    /**
     * getHits
     *
     * Returns the total amount of hits this checkpoint has received
     *
     * @return int
     */
    public function getHits() : int {
        return $this->hits;
    }
}
