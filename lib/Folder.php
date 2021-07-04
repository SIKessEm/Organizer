<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

/**
 * The folder class
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
class Folder implements Gettable, Settable {

  use Getter, Setter;

  /**
   * Create a new folder
   *
   * @param string $name The folder name
   */
  function __construct(string $name) {
    $this->setName($name);
  }

  /**
   * Set the folder name
   *
   * @param string $name The folder name
   * @throws namespace\Error If the name is not a directory
   * @return self
   */
  function setName(string $name): self {
    if(!is_dir($name))
      throw new Error("No such directory $name", Error::NOT_DIRECTORY);
    $this->name = realpath($name) . DIRECTORY_SEPARATOR;
    return $this;
  }

  /**
   * @var string The folder name
   */
  protected string $name;
}
