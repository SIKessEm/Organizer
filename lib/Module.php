<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

/**
 * The module class
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
class Module {
  /**
   * Create a new module
   *
   * @param string $file The module file
   * @param string $once Include once ?
   * @param string $vars Required vars
   */
  function __construct(string $file, protected bool $once, protected array $vars){
    if(!is_file($file))
      throw new \InvalidArgumentException("No such file $file");
    $this->file = realpath($file);
  }

  /**
   * @var string The module file
   */
  protected string $file;

  /**
   * Import the module file
   *
   * @return mixed The file returned value
   */
  function import(): mixed {
    extract($this->vars);
    return $this->once ? require_once $this->file : require $this->file;
  }
}
