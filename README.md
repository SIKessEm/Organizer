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


## Requirements

PHP 8.0.0 or above (at least 8.0.7 recommended to avoid potential bugs)


## Author

SIGUI Kessé Emmanuel | [GitHub](https://github.com/SIKessEm) | [npm](https://npmjs.org/~sikessem) | [Twitter](https://twitter.com/FullDotSIKessEm) | [sikessem@omninf.com](mailto:sikessem@omninf.com) | [sikessem.omninf.com](https://sikessem.omninf.com)


## Security Reports

Please send any sensitive issue to [sikessem@omninf.com](mailto:sikessem@omninf.com). Thanks!


## License
Organizer is licensed under the GPL-3 License - see the [LICENSE](./LICENSE) file for details.


## Contribution

For any contribution, please follow these steps:

1. Clone the repository with `git clone https://github.com/SIKessEm/Organizer` or `git remote add origin https://github.com/SIKessEm/Organizer` then `git branch -M main`
2. Create a new branch. Example: `git checkout -b my_contribution`
3. Make your changes and send them with `git push -u origin main`

You will be informed of the rest.
