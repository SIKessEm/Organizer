<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

/**
 * The package class
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
class Package implements Gettable, Settable {

  use Getter, Setter;

  /**
   * Modules extensions list
   */
  const EXTENSIONS = [
    '.php',
    '.m.php',
    '.mod.php',
    '.module.php',
  ];

  /**
   * Create a new package
   *
   * @param string $dir The package directory
   */
  function __construct(string $dir) {
    $this->setDir($dir);
  }

  /**
   * Set the package directory
   *
   * @param string $dir The new directory of the package
   * @throws namespace\Error If the directory does not exist or is not readable
   * @return self
   */
  function setDir(string $dir): self {
    if(!is_dir($dir))
      throw new Error("No such directory $dir", Error::NOT_DIRECTORY);
    if(!is_readable($dir))
      throw new Error("Cannot read directory $dir", Error::NOT_READABLE);
    $this->dir = realpath($dir) . DIRECTORY_SEPARATOR;
    return $this;
  }

  /**
   * @var string The package directory
   */
  protected string $dir;

  /**
   * @var string The package namespace
   */
  protected string $ns;

  /**
   * Import a module
   *
   * @param string $name The module name
   * @param bool $once The module is it once ?
   * @param array $vars The module required vars
   * @return mixed The module returned value
   */
  public function import(string $name, array $vars = [], bool $once = true): mixed {
    $returned = false;
    if($name === '*') {
      $returned = [];
      foreach(scandir($this->dir) as $name)
        if(!in_array($name, ['.', '..']) && is_file($file = $this->dir . DIRECTORY_SEPARATOR . $name))
          foreach(self::EXTENSIONS as $extension)
            if(strrpos($file, $extension) === strlen($extension))
              $returned[$name] = (new Module($file, $once, $vars))->import();
    } else {
    	if(preg_match('/[\/:*?"<>|]/U', $name))
    		throw new Error("Invalid name $name given", Error::INVALID_PATTERN);

      foreach(self::EXTENSIONS as $extension) {
        $path = $name;
      	while(!is_file($file = $this->dir . $path . $extension) && is_int($sepos = strpos($path, '.')))
      		$path = substr_replace($path, DIRECTORY_SEPARATOR, $sepos, 1);
    	  if(is_readable($file))
          return (new Module($file, $once, $vars))->import();
      }
    }
    return $returned;
  }

  /**
   * Attach to a sub-package
   *
   * @param string $name The sub-package name
   * @throws namespace\Error If invalid name given
   * @return namespace\Package The sub-package create
   */
  function from(string $name): self {
  	if(preg_match('/[\/:*?"<>|]/U', $name))
  		throw new Error("Invalid name $name given", Error::INVALID_PATTERN);

  	while(!is_dir($dir = $this->dir . $name) && is_int($sepos = strpos($name, '.')))
  		$name = substr_replace($name, DIRECTORY_SEPARATOR, $sepos, 1);
    return new Package($dir);
  }

  /**
   * Load objects automatically
   *
   * @param string $ns Objects namespace
   * @param string $pattern Objects pattern
   * @param string $subject Objects subject
   * @param array $globals Objects vars used
   * @return callable The autoload handle
   */
  function load(string $ns = '', string $pattern = '.*', string $subject = '\\0', array $vars = []): callable {
    if(!empty($ns) && !preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*('.preg_quote('\\', '/').'[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)*$/', $ns))
      throw new Error("Invalid namespace $ns given", Error::INVALID_NAMESPACE);

  	$loader = function(string $object) use ($ns, $pattern, $subject, $vars) {
  		if(preg_match('/^' . (empty($ns) ? '' : preg_quote("$ns\\", '/')) . '(' . $pattern . ')$/', $object, $matches))
        return $this->import(preg_replace("/^$pattern$/", $subject, $matches[1] ?? $matches[0]), $vars);
  	};
  	spl_autoload_register($loader);
  	return $loader;
  }

  /**
   * Unload objects automatically
   *
   * @param callable $handle The autoload handle
   * @return bool
   */
  function unload(callable $handle): bool {
  	return spl_autoload_unregister($handle);
  }

  /**
   * Save the render of a template
   *
   * @param array $vars The vars required
   * @param array $vars The vars required
   * @param boolean $once Include once ?
   * @return string The template render
   */
  function save(string $path, array $vars = [], bool $once = false): string {
    ob_start();
    $render = $this->import($path, $vars, $once);
    if(empty($render) || !is_string($render)) $render = ob_get_contents();
    ob_end_clean();
    return $render;
  }
}
