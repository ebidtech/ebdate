# EBDATE #

Simple wrapper around DateTime.

[![Dependency Status](https://www.versioneye.com/user/projects/52ced7d1ec13756dd000007c/badge.png)](https://www.versioneye.com/user/projects/52ced7d1ec13756dd000007c)

## Requirements ##

* PHP >= 5.4

## Installation ##

The recommended way to install is through composer.

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "ebidtech/ebdate": "@stable"
    }
}
```

**Tip:** browse [`ebidtech/ebdate`](https://packagist.org/packages/ebidtech/ebdate) page to choose a stable version to use, avoid the `@stable` meta constraint.

And run these two commands to install it:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ composer install
```

Now you can add the autoloader, and you will have access to the library:

```php
<?php

require 'vendor/autoload.php';
```

## Usage ##

Have a look on [tests as example](tests/EBT/EBDate/Tests/EBDateTimeTest.php).

## Contributing ##

See CONTRIBUTING file.

## Credits ##

* Ebidtech developer team, EBDate Lead developer [Eduardo Oliveira](https://github.com/entering) (eduardo.oliveira@ebidtech.com).
* [All contributors](https://github.com/ebidtech/ebdate/contributors)

## License ##

EBDate library is released under the MIT License. See the bundled LICENSE file for details.

