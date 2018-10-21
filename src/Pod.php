<?php
/**
 * Created for coders-strike-back.
 *
 * File: Pod.php
 * User: peterdekok
 * Date: 20/10/2018
 * Time: 22:53
 */

class Pod implements CircleInterface {

    use Circle;
    protected $checkpoints;
    protected $owner;
    protected $thrust = 100; // TODO Should these be here? -> Movable interface/trait ?
    protected $target; // TODO Should these be here?
    protected $angleToTarget = 0; // TODO Should these be here?
    protected $distanceToTarget = 0; // TODO Should these be here?

    public function __construct(string $owner) {
        $this->checkpoints = new CheckpointCollection();
        $this->radius = 400;
        $this->owner = $owner;
        $this->point = new Point(0, 0); // Dummy point... The pod needs to be somewhere
        $this->target = new Checkpoint(new Point(0, 0)); // Dummy checkpoint... The pod needs to go somewhere
    }

    /**
     * update
     *
     * Update the coordinates of the current position.
     *
     * @param \PodInput $input
     *
     * @return \Pod
     */
    public function update(PodInput $input) : Pod {
        // 0: x position of the pod
        // 1: y position of the pod
        // 2: x position of the next check point
        // 3: y position of the next check point
        // 4: distance to the next checkpoint
        // 5: angle between your pod orientation and the direction of the next checkpoint

        $this->point = $input->getPoint();

        // Input for player is more extensive compared to the input for the enemy.
        if ($input->isPlayer())
            $this->updatePlayer($input);

        return $this;
    }

    /**
     * updatePlayer
     *
     * Update the player parameters
     *
     * @param \PodInput $input
     */
    public function updatePlayer(PodInput $input) {
        $this->distanceToTarget = $input->getNextCheckpointDistance();
        $this->angleToTarget = $input->getNextCheckpointAngle();

        $lastCheckpoint = $this->getTarget();
        $nextCheckpoint = $this->checkpoints->seeCheckpoint($input->getNextCheckpointPoint());

        $this->setTarget($nextCheckpoint);

        if (!$lastCheckpoint->compare($lastCheckpoint))
            $lastCheckpoint->hit();
    }

    /**
     * getTarget
     *
     * Returns the target of the pod
     *
     * @return \Checkpoint
     */
    public function getTarget() : Checkpoint {
        return $this->target;
    }

    /**
     * setTarget
     *
     * @param \Checkpoint $point
     *
     * @return \Pod
     */
    public function setTarget(Checkpoint $point) : Pod {
        $this->target = $point;

        return $this;
    }

    /**
     * getAngleToTarget
     *
     * Return the current angle to the target
     *
     * @return int
     */
    public function getAngleToTarget() : int {
        return $this->angleToTarget;
    }

    /**
     * getDistanceToTarget
     *
     * Return the current distance to the target
     *
     * @return int
     */
    public function getDistanceToTarget() : int {
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
     * logStatus
     *
     * Output status to STDERR
     */
    public function logStatus() : void {
        $this->checkpoints->logCheckpoints();
    }

    /**
     * toString
     *
     * Return the command that can be send to STDOUT
     *
     * @return string
     */
    public function __toString() : string {
        $targetPoint = $this->getTarget()->getPoint();

        return "{$targetPoint->x()} {$targetPoint->y()} {$this->getThrust()}" . PHP_EOL;
    }
}
