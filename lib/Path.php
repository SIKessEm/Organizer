<?php
declare(strict_types=1);

namespace SIKessEm\Organizer;

/**
 * The path class
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
class Path implements Gettable, Settable {

  use Getter, Setter;

  /**
   * Create a new path
   *
   * @param string $dir The path dir
   * @param string $pattern The path pattern
   * @param array|string $extensions The path extensions
   */
  function __construct(string $dir, string $pattern, array|string $extensions) {
    $this->setDir($dir)
         ->setPattern($pattern)
         ->setExtensions((array) $extensions);
  }

  /**
   * Set the dir
   *
   * @param string $dir The path dir
   * @throws namespace\Error If the directory does not exist
   * @return self
   */
  function setDir(string $dir): self {
    if(!is_dir($dir))
      throw new Error("No such directory $dir", Error::NOT_DIRECTORY);
    $this->dir = realpath($dir) . DIRECTORY_SEPARATOR;
    return $this;
  }

  /**
   * @var string The path dir
   */
  protected string $dir;

  /**
   * Set the pattern
   *
   * @param string $pattern The path pattern
   * @throws namespace\Error If invalid pattern given
   * @return self
   */
  function setPattern(string $pattern): self {
  	if(preg_match('/[\/:*?"<>|]/U', $pattern))
  		throw new Error("Invalid pattern $pattern given", Error::INVALID_PATTERN);
    $this->pattern = $pattern;
    return $this;
  }

  /**
   * @var string The path pattern
   */
  protected string $pattern;

  /**
   * Set extensions
   *
   * @param string $extensions The path extensions
   * @throws namespace\Error If invalid extensions given
   * @return self
   */
  function setExtensions(array $extensions): self {
    $this->extensions = [];
    foreach($extensions as $extension)
      $this->addExtension($extension);
    return $this;
  }

  /**
   * Add a new extension
   *
   * @param string $extension The new extension
   * @throws namespace\Error If invalid extension given
   * @return self
   */
  function addExtension(string $extension): self {
  	if(!preg_match('/^[\w-]+$/', $extension))
  		throw new Error("Invalid extension $extension given", Error::INVALID_EXTENSION);
    $this->extensions[] = $extension;
    return $this;
  }

  /**
   * @var array The path extensions
   */
  protected array $extensions;

  public function getFile(): string {
    foreach($this->extensions as $extension) {
      $name = $this->pattern;
    	while(!is_file($file = $this->dir . "$name.$extension") && is_int($sepos = strpos($name, '.')))
    		$name = substr_replace($name, DIRECTORY_SEPARATOR, $sepos, 1);
  	  if(is_readable($file))
        return $file;
    } return '';
  }
}
