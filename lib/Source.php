<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

/**
 * The source class
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
class Source {
  /**
   * Create a new source
   *
   * @param string $file The source file
   * @param string $once Include once ?
   * @param string $vars Required vars
   */
  function __construct(string $file, protected bool $once, protected array $vars){
    if(!is_file($file))
      throw new \InvalidArgumentException("No such file $file");
    $this->file = realpath($file);
  }

  /**
   * @var string The source file
   */
  protected string $file;

  /**
   * Include the source file
   *
   * @return mixed The file returned value
   */
  function include(): mixed {
    extract($this->vars);
    return $this->once ? require_once $this->file : require $this->file;
  }
}
