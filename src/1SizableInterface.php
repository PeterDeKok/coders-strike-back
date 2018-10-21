<?php
/**
 * Created for coders-strike-back.
 *
 * File: SizableInterface.php
 * User: peterdekok
 * Date: 21/10/2018
 * Time: 12:23
 */

interface SizableInterface extends PointableInterface {

    /**
     * collision
     *
     * Returns whether the radii of this and another object are overlapping
     *
     * @param \SizableInterface $sizable
     *
     * @return bool
     */
    public function collision(SizableInterface $sizable) : bool;

    /**
     * inside
     *
     * Returns whether the provided point is inside this sizable
     *
     * @param \PointableInterface $pointable
     *
     * @return bool
     */
    public function inside(PointableInterface $pointable) : bool;
}
