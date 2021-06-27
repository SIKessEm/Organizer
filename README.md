# Organizer
A PHP file manager


## Installation

Use Composer to install the library with this command:

`composer require sikessem/organizer`

Or [click here to download it directly in ZIP format ](https://github.com/SIKessEm/Organizer/archive/refs/heads/main.zip)


## Usage

If you are using Composer, include the Composer autoload file.
Otherwise, you can use the example below in all cases:

1. Go to your working directory with the command `cd my_working_directory` where **_my_working_directory_** is your working directory
2. Create the **_test.php_** file with the command `touch test.php`
3. Open the new file (**_test.php_**) in your code editor
4. Copy and paste the code below:
```php
#!/usr/bin/php
<?php

use SIKessEm\Organizer\System as Organizer;

/**
 * @var string The real path of Organizer
 */
$organizer_dir = __DIR__ . '/vendor/sikessem/organizer';

require_once $organizer_dir . "/lib/autoload.php";

/*
  0- Create a new organizer system
  1- extract(['author' => 'SIGUI Kessé Emmanuel (SIKessEm) <sikessem@omninf.com>']);
  2- require __DIR__ . '/config/params.php' into a variable;
  3- return the variable or included value
  4- print the returned value
  5- end the script
 */
$sys = new Organizer(__DIR__);
$settings = $sys->import('config.params', ['author' => 'SIGUI Kessé Emmanuel (SIKessEm) <sikessem@omninf.com>'], false);
print_r($settings);
exit;
```
5. Create the **_config/params.php_** file with this example code:
```php
<?php
return [
  'author' => $author,
  'pattern' => 'config.params',
];
```
6. Run `php test.php`
