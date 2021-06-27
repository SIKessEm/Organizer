<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

/**
 * The system class
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
class System {
  use SystemTrait;

  /**
   * Create a new system
   *
   * @param string $dir The system directory
   */
  function __construct(string $dir) {
    $this->init($dir);
  }
}
