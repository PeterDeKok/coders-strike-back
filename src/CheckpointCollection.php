<?php
/**
 * Created for coders-strike-back.
 *
 * File: CheckpointCollection.php
 * User: peterdekok
 * Date: 20/10/2018
 * Time: 20:31
 */

class CheckpointCollection implements ArrayAccess, Iterator, Countable {

    /**
     * @var \Checkpoint[] $checkpoints
     */
    private $checkpoints = [];

    /**
     * @return \Checkpoint[]
     */
    public function getCheckpoints() : array {
        return $this->checkpoints;
    }

    /**
     * getCheckpoint
     *
     * @param int $id
     *
     * @return \Checkpoint|null
     */
    public function getCheckpoint(int $id) : ?Checkpoint {
        return $this->checkpoints[$id] ?? null;
    }

    /**
     * findCheckpoint
     *
     * @param \PointableInterface|int $point
     * @param int|null $pointY
     *
     * @return int
     * @throws \Exception
     */
    public function findCheckpoint($point, int $pointY = null) {
        if (is_int($point) && !is_null($pointY)) {
            $x = $point;
            $y = $pointY;
        } else if (($point instanceof PointableInterface) && !is_null($point->getPoint())) {
            $x = $point->getPoint()->x();
            $y = $point->getPoint()->y();
        } else {
            throw new \Exception('Cannot process checkpoint without valid point');
        }

        foreach ($this->getCheckpoints() as $id => $checkpoint) {
            if ($x === $checkpoint->getPoint()->x() && $y === $checkpoint->getPoint()->y())
                return $id;
        }

        return -1;
    }

    /**
     * seeCheckpoint
     *
     * @param \PointableInterface|int $point
     * @param int|null $pointY
     *
     * @return int|string
     * @throws \Exception
     */
    public function seeCheckpoint($point, int $pointY = null) {
        if (is_int($point) && !is_null($pointY)) {
            $found = $this->findCheckpoint($point, $pointY);
        } else if (($point instanceof PointableInterface) && !is_null($point->getPoint())) {
            $found = $this->findCheckpoint($point->getPoint()->x(), $point->getPoint()->x());
        } else {
            throw new \Exception('Cannot process checkpoint without valid point');
        }

        if ($found < 0) {
            try {
                $checkpoint = ($point instanceof Checkpoint) ? $point : new Checkpoint($point, $pointY);

                $found = array_push($this->checkpoints, $checkpoint) - 1;
            } catch (Exception $e) {
                $found = -1;
            }
        }

        return $found;
    }

    /**
     * logCheckpoints
     *
     * Logs a list of the checkpoints to STDERR
     */
    public function logCheckpoints() {
        $temp = [];

        foreach($this as $id => $checkpoint) {
            $temp[] = "  $id (hit {$checkpoint->getHits()}x): {$checkpoint->getPoint()->x()} x {$checkpoint->getPoint()->y()}";
        }

        error_log("Checkpoints:\n" . implode("\n", $temp));
    }

    /**
     * offsetSet
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @throws \Exception
     */
    public function offsetSet($offset, $value) : void {
        if (!($value instanceof Checkpoint))
            throw new Exception('value must be an instance of Checkpoint');

        if (is_null($offset)) {
            $this->checkpoints[] = $value;
        } else {
            $this->checkpoints[$offset] = $value;
        }
    }

    /**
     * offsetExists
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset) : bool {
        return isset($this->checkpoints[$offset]);
    }

    /**
     * offsetUnset
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset) : void {
        unset($this->checkpoints[$offset]);
    }

    /**
     * offsetGet
     *
     * @param mixed $offset
     *
     * @return \Checkpoint|null
     */
    public function offsetGet($offset) : ?Checkpoint {
        return $this->checkpoints[$offset] ?? null;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return \Checkpoint|false Can return any type.
     * @since 5.0.0
     */
    public function current() {
        return current($this->checkpoints);
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next() {
        next($this->checkpoints);
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key() {
        return key($this->checkpoints);
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid() {
        return isset($this->checkpoints[$this->key()]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind() {
        reset($this->checkpoints);
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count() {
        return count($this->checkpoints);
    }
}
