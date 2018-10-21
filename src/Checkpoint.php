<?php
/**
 * Created for coders-strike-back.
 *
 * File: Checkpoint.php
 * User: peterdekok
 * Date: 20/10/2018
 * Time: 17:51
 */

class Checkpoint implements CircleInterface {

    use Circle;
    protected $hits = 0;
    protected $next;
    protected $previous;

    /**
     * Checkpoint constructor.
     *
     * @param \PointableInterface $point
     */
    public function __construct(PointableInterface $point) {
        $this->radius = 600;
        $this->point = $point->getPoint();
        $this->next = $this;
        $this->previous = $this;
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

    /**
     * compare
     *
     * Returns if the coordinates of this checkpoint and the provided checkpoint are the same
     *
     * @param \Checkpoint $other
     *
     * @return bool
     */
    public function compare(Checkpoint $other) : bool {
        return $this->getPoint()->compare($other->getPoint());
    }

    /**
     * @return \Checkpoint
     */
    public function next() : Checkpoint {
        return $this->next;
    }

    /**
     * @param mixed $next
     */
    public function setNext($next) : void {
        $this->next = $next;
    }

    /**
     * @return \Checkpoint
     */
    public function previous() : Checkpoint {
        return $this->previous;
    }

    /**
     * @param mixed $previous
     */
    public function setPrevious($previous) : void {
        $this->previous = $previous;
    }
}
