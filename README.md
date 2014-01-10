# EBDate #

Simple wrapper around DateTime.

[![Latest Stable Version](https://poser.pugx.org/ebidtech/ebdate/v/stable.png)](https://packagist.org/packages/ebidtech/ebdate) [![Build Status](https://travis-ci.org/ebidtech/ebdate.png?branch=master)](https://travis-ci.org/ebidtech/ebdate) [![Coverage Status](https://coveralls.io/repos/ebidtech/ebdate/badge.png?branch=master)](https://coveralls.io/r/ebidtech/ebdate?branch=master) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/ebidtech/ebdate/badges/quality-score.png?s=0d65743216585bb6c490b0408195a061d4b68ba4)](https://scrutinizer-ci.com/g/ebidtech/ebdate/) [![Dependency Status](https://www.versioneye.com/user/projects/52ced7d1ec13756dd000007c/badge.png)](https://www.versioneye.com/user/projects/52ced7d1ec13756dd000007c)

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

