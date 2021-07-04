<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

/**
 * The system interface
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
interface SystemInterface {
  /**
   * Initialize the system
   *
   * @param string $dir The system directory
   * @return self
   */
  function init(string $dir): self;

  /**
   * Import a file
   *
   * @param string $path The file path
   * @param array $vars Required vars
   * @param boolean $once Include once ?
   * @return mixed The file returned value
   */
  public function import(string $path, array $vars = [], bool $once = true): mixed;

  /**
   * Get the real path of a name
   *
   * @param string $name The path name
   * @param string $extension The path extension
   * @throws \RuntimeException If the name is not valid
   * @return false|string The path file real name if exists
   */
  public function path(string $name, string $extension = 'php'): string;

  /**
   * Load objects automatically
   *
   * @param string $ns The objects namespace
   * @param string $pattern The objects pattern
   * @param string $subject The objects subject
   * @param array $globals The vars used
   * @return callable The autoload handle
   */
  public function load(string $ns = '', string $pattern = '.*', string $subject = '\\0', array $vars = []): callable;

  /**
   * Unload objects automatically
   *
   * @param callable $handle The autoload handle
   * @return bool
   */
  public function unload(callable $handle): bool;

  /**
   * Save the render of a template
   *
   * @param array $vars The vars required
   * @param array $vars The vars required
   * @param boolean $once Include once ?
   * @return string The template render
   */
  public function save(string $path, array $vars = [], bool $once = false): string;
}
