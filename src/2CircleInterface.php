<?php
/**
 * Created for coders-strike-back.
 *
 * File: CircleInterface.php
 * User: peterdekok
 * Date: 21/10/2018
 * Time: 13:30
 */

interface CircleInterface extends SizableInterface {

    /**
     * getRadius
     *
     * Returns the radius of this object
     *
     * @return int
     */
    public function getRadius() : int;
}
