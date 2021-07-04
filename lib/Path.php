<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

/**
 * The path class
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
class Path implements Gettable, Settable {

  use Getter, Setter;

  /**
   * Create a new path
   *
   * @param string $name The path name
   */
  function __construct(protected string $name) {}
}
