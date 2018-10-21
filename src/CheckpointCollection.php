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
        return $this[$id] ?? null;
    }

    /**
     * findCheckpoint
     *
     * Return the checkpoint corresponding to the provided pointable if it exists
     *
     * @param \PointableInterface $point
     *
     * @return \Checkpoint|null
     */
    public function findCheckpoint(PointableInterface $point) : ?Checkpoint {
        return $this->getCheckpoint($this->findCheckpointId($point));
    }

    /**
     * findCheckpointId
     *
     * Return the checkpoint ID corresponding to the provided pointable.
     * If it does not exist, return -1
     *
     * @param \PointableInterface $point
     *
     * @return int
     */
    public function findCheckpointId(PointableInterface $point) : int {
        foreach ($this->getCheckpoints() as $id => $checkpoint) {
            if ($checkpoint->getPoint()->compare($point))
                return $id;
        }

        return -1;
    }

    /**
     * seeCheckpoint
     *
     * @param \PointableInterface $point
     *
     * @return \Checkpoint
     */
    public function seeCheckpoint(PointableInterface $point) : Checkpoint {
        if (is_null($checkpoint = $this->findCheckpoint($point))) {
            $checkpoint = ($point instanceof Checkpoint) ? $point : new Checkpoint($point);

            $this->addCheckpoint($checkpoint);
        }

        return $checkpoint;
    }

    protected function addCheckpoint(Checkpoint $checkpoint) {
        if ($this->count() > 0) {
            $firstCheckpoint = $this->rewind();
            $lastCheckpoint = $this->end();

            $checkpoint->setPrevious($lastCheckpoint);
            $checkpoint->setNext($firstCheckpoint);

            $lastCheckpoint->setNext($checkpoint);
            $firstCheckpoint->setPrevious($checkpoint);
        }

        array_push($this->checkpoints, $checkpoint);
    }

    /**
     * logCheckpoints
     *
     * Logs a list of the checkpoints to STDERR
     */
    public function logCheckpoints() : void {
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
     * @return \Checkpoint|false The value of the first checkpoint or false for empty array. For the iterator, any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind() {
        return reset($this->checkpoints);
    }

    /**
     * Set the internal pointer of an array to its last element
     * @link https://php.net/manual/en/function.end.php
     * @return \Checkpoint|false The value of the last checkpoint or false for empty array.
     * @since 4.0
     * @since 5.0
     */
    public function end() {
        return end($this->checkpoints);
    }

    /**
     * Count of checkpoints
     * @link https://php.net/manual/en/countable.count.php
     * @return int The count as an integer.
     * @since 5.1.0
     */
    public function count() {
        return count($this->checkpoints);
    }
}
