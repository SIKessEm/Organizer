<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

/**
 * The system trait
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
trait SystemTrait {
  /**
   * Initialize the system
   *
   * @param string $dir The system directory
   * @throws \InvalidArgumentException If no such directory
   * @return self
   */
  function init(string $dir): self {
    if(!isset($this->folder))
      $this->folder = new Folder($dir);
    else
      $this->folder->setName($dir);
    return $this;
  }

  /**
   * @var namespace\Folder The system folder
   */
  protected Folder $folder;

  /**
   * Import a file
   *
   * @param string $path The file path
   * @param array $vars Required vars
   * @param boolean $once Include once ?
   * @return mixed The file returned value
   */
  function import(string $path, array $vars = [], bool $once = true): mixed {
    return $this->module($path, $vars, $once)->import();
  }

  /**
   * Load objects automatically
   *
   * @param string $ns The objects namespace
   * @param string $pattern The objects pattern
   * @param string $subject The objects subject
   * @param array $globals The vars used
   * @return callable The autoload handle
   */
  function load(string $ns = '', string $pattern = '.*', string $subject = '\\0', array $vars = []): callable {
  	return $this->package($ns)->load($pattern, $subject, $vars);
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

  /**
   * Get a module of the system
   *
   * @param string $name The module name
   * @param bool $once The module is it once ?
   * @param array $vars The module required vars
   * @return namespace\Module The module getted
   */
  public function module(string $name, array $vars = [], bool $once = true): Module {
    return new Module($this->folder, $name, $once, $vars);
  }

  /**
   * Get a package of the system
   *
   * @param string $ns The package namespace
   * @return namespace\Package The package getted
   */
  public function package(string $ns): Package {
    return new Package($this->folder, $ns);
  }
}
