<?php
/*
 +------------------------------------------+
 |      THE ORGANIZER OBJECT AUTOLOAD       |
 +------------------------------------------+
 | Author : SIGUI Kessé Emmanuel (SIKessEm) |
 | License : Apache 2.0                     |
 +------------------------------------------+
 */
(function(){
  $namespace = 'SIKessEm\\Organizer\\';
  $directory = __DIR__ . DIRECTORY_SEPARATOR;
  $extension = '.php';

  spl_autoload_register(function(string $object) use ($namespace, $directory, $extension){
      $namespace = preg_quote($namespace, '/');
      if(preg_match("/^$namespace(.*)$/", $object, $matches)) {
          require_once $directory . str_replace('\\', DIRECTORY_SEPARATOR, $matches[1]) . $extension;
      }
    }, true, true);
})();
