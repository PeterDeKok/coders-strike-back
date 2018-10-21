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
    protected $booster = false;
    protected $boosted = false;
    protected $lastDist = 0;
    protected $thrustDiff = 0;
    protected $lap = 0;

    public function __construct(string $owner, bool $booster = false) {
        $this->checkpoints = new CheckpointCollection();
        $this->radius = 400;
        $this->owner = $owner;
        $this->point = new Point(0, 0); // Dummy point... The pod needs to be somewhere
        $this->target = new Checkpoint(new Point(0, 0)); // Dummy checkpoint... The pod needs to go somewhere
        $this->booster = $booster;
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

        $this->lastDist = $input->getPoint()->distanceTo($this) * 10000;

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

        $newThrust = $this->calculateThrust();

        $this->thrustDiff = $newThrust - $this->thrust;

        $this->setThrust($newThrust);

        if (!$nextCheckpoint->compare($lastCheckpoint))
            $this->lap = $lastCheckpoint->hit();
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
        return $this->thrust;
    }

    /**
     * setThrust
     *
     * @param int $thrust
     */
    protected function setThrust(int $thrust) {
        $this->thrust = $thrust;
    }

    /**
     * calculateThrust
     *
     * Calculate thrust based on pod stats
     *
     * @return int
     */
    protected function calculateThrust() : int {
        $absAngle = abs($this->getAngleToTarget());

        if ($absAngle > 90)
            return 2;

        if ($absAngle < 2 || ($absAngle < 15 && $this->getDistanceToTarget() < 800))
            return 100;

        if ($this->getDistanceToTarget() < 1000)
            return 30;

        if ($this->getDistanceToTarget() < 1500)
            return 45;

        if ($this->getDistanceToTarget() < 2000)
            return 60;

        return 100;
    }

    /**
     * getLap
     *
     * Return the current lap of the pod
     *
     * @return int
     */
    public function getLap() : int {
        return $this->lap;
    }

    /**
     * logStatus
     *
     * Output status to STDERR
     *
     * @param bool $sendToSTDERR
     *
     * @return string
     */
    public function logStatus(bool $sendToSTDERR = true) : string {
        $message = "{$this->owner}\n-----\nBoosted? ";
        $message .= $this->boosted ? 'TRUE' : 'FALSE';
        $message .= "}\n-----\n";
        $message .= $this->checkpoints->logCheckpoints(false);

        if ($sendToSTDERR)
            error_log($message);

        return $message;
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

        if ($this->booster && $this->getLap() > 1 && !$this->boosted && $this->getAngleToTarget() < 5 && $this->getDistanceToTarget() > 6000) {
            $thrust = 'BOOST';
            $this->boosted = true;
        } else {
            $thrust = $this->getThrust();
        }

        return "{$targetPoint->x()} {$targetPoint->y()} {$thrust}" . PHP_EOL;
    }
}
