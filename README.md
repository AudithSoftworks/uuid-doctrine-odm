# uuid-doctrine-odm

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Total Downloads][ico-downloads]][link-downloads]

Allow the use of a ramsey/uuid UUID as Doctrine ODM field type.

## Install

Via Composer

``` bash
$ composer require audithsoftworks/uuid-doctrine-odm
```

## Usage

``` php
<?php

use Doctrine\ODM\MongoDB\Types\Type;

Type::registerType('ramsey_uuid', \AudithSoftworks\Uuid\Doctrine\ODM\UuidType::class);
Type::registerType('ramsey_uuid_binary', \AudithSoftworks\Uuid\Doctrine\ODM\UuidBinaryType::class);

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Credits

- [Shahriyar Imanov][link-author] (v2.x and v3.x)
- [Johan de Ruijter][link-old-author] (v1.x)
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/audithsoftworks/uuid-doctrine-odm.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://www.travis-ci.com/AudithSoftworks/uuid-doctrine-odm.svg?branch=master&status=started
[ico-downloads]: https://img.shields.io/packagist/dt/audithsoftworks/uuid-doctrine-odm.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/audithsoftworks/uuid-doctrine-odm
[link-travis]: https://travis-ci.org/AudithSoftworks/uuid-doctrine-odm
[link-downloads]: https://packagist.org/packages/audithsoftworks/uuid-doctrine-odm
[link-author]: https://github.com/AudithSoftworks
[link-old-author]: https://github.com/johanderuijter
[link-contributors]: ../../contributors
