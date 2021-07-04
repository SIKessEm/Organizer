<?php namespace SIKessEm\Organizer;

/**
 * Properties setter trait
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
trait Setter {

  /**
   * Set a property
   *
   * @param string $name The property name
   * @param mixed $value The property value
   * @throws namespace\Error If undefined method
   * @return void
   */
  public function __set(string $name, mixed $value): void {
    if(!method_exists($this, $set = 'set' . ucFirst($name)) && !method_exists($this, $set = 'add'  . ucFirst($name)))
      throw new Error("Cannot set the property $name", Error::SET_PROPERTY);
    $this->$set($value);
  }
}
