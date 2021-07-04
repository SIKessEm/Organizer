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
   * Create a new package
   *
   * @param Folder $folder The package folder
   * @param string $ns The package namespace
   */
  function __construct(protected Folder $folder, string $ns = '') {
    $this->setNS($ns);
  }

  /**
   * Set the package namespace
   *
   * @param string $ns The package namespace
   * @throws namespace\Error If the namespace is not valid
   * @return self
   */
  function setNS(string $ns): self {
    if(!empty($ns) && !preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*(\\[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)*$/', $ns))
      throw new Error("Invalid namespace $ns given", Error::INVALID_NAMESPACE);
    $this->ns = $ns;
    return $this;
  }

  /**
   * @var string The package namespace
   */
  protected string $ns;

  /**
   * Load objects automatically
   *
   * @param string $pattern Objects pattern
   * @param string $subject Objects subject
   * @param array $globals Objects vars used
   * @return callable The autoload handle
   */
  function load(string $pattern = '.*', string $subject = '\\0', array $vars = []): callable {
  	$loader = function(string $object) use ($pattern, $subject, $vars) {
      $ns = $this->ns;
  		if(preg_match('/^' . (empty($ns) ? '' : preg_quote("$ns\\", '/')) . '(' . $pattern . ')$/', $object, $matches)) {
        if($file = (new Path($this->folder, preg_replace("/^$pattern$/", $subject, $matches[1] ?? $matches[0]), ['php']))->getFile())
          return (new Module($file, true, $vars))->import();
      }
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
}
