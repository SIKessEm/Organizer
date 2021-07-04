<?php namespace SIKessEm\Organizer;

/**
 * Properties settable interface
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
interface Settable {

  /**
   * Set a property
   *
   * @param string $name The property name
   * @param mixed $value The property value
   * @return void
   */
  public function __set(string $name, mixed $value): void;
}
