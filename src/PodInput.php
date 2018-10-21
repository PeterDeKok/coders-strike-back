<?php
/**
 * Created for coders-strike-back.
 *
 * File: PodInput.php
 * User: peterdekok
 * Date: 21/10/2018
 * Time: 15:22
 */

class PodInput {
    protected $input;
    protected $point;
    protected $nextCheckpointPoint;
    protected $nextCheckpointDistance;
    protected $nextCheckpointAngle;

    public function __construct($input) {
        $this->input = $input;

        $this->point = new Point($input[0], $input[1]);

        if (count($input) === 6) {
            $this->nextCheckpointPoint = new Point($input[2], $input[3]);
            $this->nextCheckpointDistance = $input[4];
            $this->nextCheckpointAngle = $input[5];
        }
    }

    /**
     * @return mixed
     */
    public function getInput() : array {
        return $this->input;
    }

    /**
     * @return \Point
     */
    public function getPoint() : Point {
        return $this->point;
    }

    /**
     * @return \Point
     */
    public function getNextCheckpointPoint() : ?Point {
        return $this->nextCheckpointPoint;
    }

    /**
     * @return int
     */
    public function getNextCheckpointDistance() : ?int {
        return $this->nextCheckpointDistance;
    }

    /**
     * @return int
     */
    public function getNextCheckpointAngle() : ?int {
        return $this->nextCheckpointAngle;
    }
}
