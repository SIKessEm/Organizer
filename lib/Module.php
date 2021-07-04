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
   * Modules extensions list
   */
  const EXTENSIONS = [
    'module.php',
    'mod.php',
    'm.php',
    'php',
  ];

  /**
   *
   * Create a new module
   * @param string $folder The module folder
   * @param string $name The module name
   * @param bool $once The module is it once ?
   * @param array $vars The module required vars
   */
  function __construct(protected Folder $folder, string $name, protected bool $once, array $vars = []) {
    $this->setName($name);
    $this->isOnce($once);
    $this->setVars($vars, true);
  }

  /**
   * Set the name
   *
   * @param string $name The module name
   * @throws namespace\Error If invalid name given
   * @return self
   */
  function setName(string $name): self {
  	if(preg_match('/[\/:*?"<>|]/U', $name))
  		throw new Error("Invalid name $name given", Error::INVALID_PATTERN);
    $this->name = $name;
    return $this;
  }

  /**
   * @var string The module name
   */
  protected string $name;

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
    return $this->once ? require_once $this->file() : require $this->file();
  }

  public function file(): string {
    foreach(self::EXTENSIONS as $extension) {
      $name = $this->name;
    	while(!is_file($file = $this->folder->name . "$name.$extension") && is_int($sepos = strpos($name, '.')))
    		$name = substr_replace($name, DIRECTORY_SEPARATOR, $sepos, 1);
  	  if(is_readable($file))
        return $file;
    } return '';
  }
}
