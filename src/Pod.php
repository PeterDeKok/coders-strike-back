<?php
/**
 * Created for coders-strike-back.
 *
 * File: Pod.php
 * User: peterdekok
 * Date: 20/10/2018
 * Time: 22:53
 */

class Pod implements PointableInterface {

    use Pointable;
    protected $target;
    protected $thrust = 100;
    protected $owner;
    protected $angleToTarget = 0; // TODO Should these be here?
    protected $distanceToTarget = 0; // TODO Should these be here?

    public function __construct(string $owner) {
        $this->owner = $owner;
        $this->target = new Point(0, 0);
    }

    /**
     * isActive
     *
     * Returns if the pod is initialized
     *
     * @return bool
     */
    public function isActive() {
        return !is_null($this->getPoint());
    }

    /**
     * update
     *
     * Update the coordinates of the current position.
     * Returns true if the target changes.
     *
     * @param array $input
     *
     * @return bool
     */
    public function update(array $input) : bool {
        // 0: x position of the pod
        // 1: y position of the pod
        // 2: x position of the next check point
        // 3: y position of the next check point
        // 4: distance to the next checkpoint
        // 5: angle between your pod orientation and the direction of the next checkpoint

        if (is_null($this->point))
            $this->point = new Point($input[0], $input[1]);
        else
            $this->point->update($input[0], $input[1]);

        if (count($input) >= 6) {
            $this->distanceToTarget = $input[4];
            $this->angleToTarget = $input[5];

            if ($this->getTarget()->x() !== $input[2] && $this->getTarget()->y() !== $input[3])
                return true;
        }

        return false;
    }

    /**
     * getTarget
     *
     * Returns the target of the pod
     *
     * @return \Point
     */
    public function getTarget() : Point {
        return $this->target;
    }

    /**
     * setTarget
     *
     * @param \PointableInterface|int $point
     * @param int|null $pointY
     *
     * @return \Pod
     * @throws \Exception
     */
    public function setTarget($point, int $pointY = null) : Pod {
        if (is_int($point) && !is_null($pointY))
            $this->target = new Point($point, $pointY);
        else if (($point instanceof PointableInterface) && !is_null($point->getPoint()))
            $this->target = $point->getPoint();
        else
            throw new \Exception('Cannot initialize checkpoint without valid point');

        return $this;
    }

    /**
     * getAngleToTarget
     *
     * Return the current angle to the target
     *
     * @return int
     */
    public function getAngleToTarget() {
        return $this->angleToTarget;
    }

    /**
     * getDistanceToTarget
     *
     * Return the current distance to the target
     *
     * @return int
     */
    public function getDistanceToTarget() {
        return $this->distanceToTarget;
    }

    /**
     * getThrust
     *
     * Return the thrust the pod should apply
     *
     * @return int
     */
    public function getThrust() : int {
        if (abs($this->getAngleToTarget()) > 90)
            return 0;

        if ($this->getDistanceToTarget() < 800)
            return 35;

        if ($this->getDistanceToTarget() < 1200)
            return 70;

        return $this->thrust;
    }

    /**
     * toString
     *
     * Return the command that can be send to STDOUT
     *
     * @return string
     */
    public function __toString() : string {
        if (!$this->isActive())
            return PHP_EOL;

        return "{$this->getTarget()->x()} {$this->getTarget()->y()} {$this->getThrust()}" . PHP_EOL;
    }
}
