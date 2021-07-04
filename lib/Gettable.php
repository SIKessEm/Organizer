<?php namespace SIKessEm\Organizer;

/**
 * Properties gettable interface
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
interface Gettable {

  /**
   * Get a property
   *
   * @param string $name The property name
   * @return mixed The property value
   */
  public function __get(string $name): mixed;
}
