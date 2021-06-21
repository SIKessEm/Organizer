<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

class Source {
  function __construct(protected string $file, protected bool $once, protected array $vars){}

  /**
   * Include the source file
   */
  function include(): mixed {
    if(is_file($this->file)) {
      extract($this->vars);
      return $this->once ? require_once $this->file : require $this->file;
    } return false;
  }
}
