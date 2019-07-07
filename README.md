# Beyonic PHP Library

Php library for the http://beyonic.com API

It requires PHP version 5.4+

## Installation

### Manual

To use the library, download the latest release and uncompress it in a location that's on your project's include path.

Once that's done, you can include the library in your scripts as follows:

```php
require('./lib/Beyonic.php');
```

### Composer

To install the library via [Composer](https://getcomposer.org/), add composer.json:

```json
{
  "require": {
    "beyonic/beyonic-php": "*"
  }
}
```

## Usage

Please visit http://support.beyonic.com/api for usage documentation

[![Latest Stable Version](https://poser.pugx.org/beyonic/beyonic-php/v/stable.svg)](https://packagist.org/packages/beyonic/beyonic-php) [![Latest Unstable Version](https://poser.pugx.org/beyonic/beyonic-php/v/unstable.svg)](https://packagist.org/packages/beyonic/beyonic-php) [![Total Downloads](https://poser.pugx.org/beyonic/beyonic-php/downloads.svg)](https://packagist.org/packages/beyonic/beyonic-php) [![License](https://poser.pugx.org/beyonic/beyonic-php/license.svg)](https://packagist.org/packages/beyonic/beyonic-php)


## Changelog

# 0.0.11

Adding Network and Currency APIs, and adding ability to set Duplicate-Check-Key header for each create() or update() request.

# 0.0.14

Bug fixes that prevented Network and Currency APIs from working in 0.0.11, 0.0.12 and 0.0.13

# 0.0.15

Bug fixes
