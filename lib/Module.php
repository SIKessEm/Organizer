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
class Module implements Gettable, Settable  {

  use Getter, Setter;

  /**
   *
   * Create a new module
   * @param string $file The module file
   * @param bool $once The module is it once ?
   * @param array $vars The module required vars
   */
  function __construct(string $file, bool $once, array $vars = []) {
    $this->setFile($file)->isOnce($once);
    $this->setVars($vars, true);
  }

  /**
   * Set the module file
   *
   * @param string $file The module file
   * @throws namespace\Error If the file does not exist or is not readable
   * @return self
   */
  function setFile(string $file): self {
    if(!is_file($file))
      throw new Error("No such file $file", Error::NOT_FILE);
    if(!is_readable($file))
      throw new Error("Cannot read file $file", Error::NOT_READABLE);
    $this->file = realpath($file);
    return $this;
  }

  /**
   * @var string The module file
   */
  protected string $file;

  /**
   * Check if the module is once
   *
   * @param bool|null $once The module is it once ?
   * @return bool The module is once
   */
  function isOnce(?bool $once = null): bool {
    return !isset($once) ? $this->once : $this->once = $once;
  }

  /**
   * @var bool|null The module is it once ?
   */
  protected bool $once;

  /**
   * Set vars
   *
   * @param string $vars The module vars
   * @param bool $reset Reset existing vars ?
   * @return self
   */
  function setVars(array $vars, bool $reset): self {
    if($reset)
      $this->vars = [];

    foreach($vars as $name => $value)
      $this->addVar($name, $value);
    return $this;
  }

  /**
   * Set a var
   *
   * @param string $name The var name
   * @param mixed $value The var value
   * @throws namespace\Error If invalid var name given
   * @return self
   */
  function setVar(string $name, $value): self {
  	if(!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name))
  		throw new Error("Invalid var name $name given", Error::INVALID_VARNAME);
    $this->vars[$name] = $value;
    return $this;
  }

  /**
   * @var array The module vars
   */
  protected array $vars;

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
