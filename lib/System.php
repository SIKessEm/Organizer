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
  /**
   * Create a new system
   *
   * @param string $dir The system directory
   */
  function __construct(string $dir) {
    if(!is_dir($dir))
      throw new \InvalidArgumentException("No such directory $dir");
    $this->dir = realpath($dir) . DIRECTORY_SEPARATOR;
  }

  /**
   * Get the system directory
   *
   * @return string The system directory
   */
  function dir(): string {
    return $this->dir;
  }

  /**
   * Import a file
   *
   * @param string $path The file path
   * @param array $vars Required vars
   * @param boolean $once Include once ?
   * @return mixed The file returned value
   */
  function import(string $path, array $vars = [], bool $once = true): mixed {
    return (new Source($this->path($path), $once, $vars))->include();
  }

  /**
   * Get the real path of a name
   *
   * @param string $name The path name
   * @param string $extension The path extension
   * @throws \RuntimeException If the name is not valid
   * @return false|string The path file real name if exists
   */
  function path(string $name, string $extension = 'php'): string {
  	if(preg_match('/[\/:*?"<>|]/U', $name))
  		throw new \RuntimeException("Invalid name $name given", E_USER_ERROR);
  	while(!is_file($file = $this->dir() . "$name.$extension") && is_int($sepos = strpos($name, '.')))
  		$name = substr_replace($name, DIRECTORY_SEPARATOR, $sepos, 1);
  	return is_readable($file) ? $file : '';
  }

  /**
   * Load objects automatically
   *
   * @param string $path The objects path
   * @param string $pack The objects namespace
   * @param string $pattern The objects pattern
   * @param string $subject The objects subject
   * @param array $globals The vars used
   * @return callable The autoload handle
   */
  function load(string $path, string $pack = '', string $pattern = '.*', string $subject = '\\0', array $vars = []): callable {
  	$loader = function(string $object) use ($path, $pack, $pattern, $subject, $vars) {
  		if(preg_match('/^' . (empty($pack) ? '' : preg_quote("$pack\\", '/')) . '(' . $pattern . ')$/', $object, $matches))
  			$this->import($path . '.' . preg_replace("/^$pattern$/", $subject, $matches[1] ?? $matches[0]), $vars);
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
