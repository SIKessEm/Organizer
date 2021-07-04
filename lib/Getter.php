<?php namespace SIKessEm\Organizer;

/**
 * Properties getter trait
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
trait Getter {

  /**
   * Get a property
   *
   * @param string $name The property name
   * @throws namespace\Error If undefined property
   * @return mixed The property value
   */
  public function __get(string $name): mixed {
    if(!property_exists($this, $name))
      throw new Error("Undefined property $name given", Error::GET_PROPERTY);
    return $this->$name;
  }
}
