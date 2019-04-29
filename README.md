# Beyonic PHP Library

Php library for the http://beyonic.com API

It requires PHP version 5.4+

## Installation

### Manual

To use the library, download the latest release and uncompress it in a location that's on your project's include path.

Once that's done, you can include the library in your scripts as follows:

```php
use Beyonic\Beyonic;

require "vendor/autoload.php";
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


## **Examples for an instance object**

```php

use Beyonic\Beyonic;

require "vendor/autoload.php";

/**
 * Instance usage
 */
$beyonic = new Beyonic('840604c20904844jjdjfhdj8747673n43j33k93');

/**
 * Make a Payment i.e access the \Beyonic\Collection\Payment object
 * Through this one instance
 */

$values = [
    "phonenumber" => '+256702455228',
    "amount" => '500',
    "currency" => "UGX",
    "description" => 'Units Payment',
    "metadata" => ['id' => '58475848kdd', 'appId' => 'Company Details Payment'],
    "send_instructions" => true
];
$beyonic->payment()->create($values);

/**
 * Make a Request i.e access the \Beyonic\Collection\Request object
 * Through this one instance
 */

 $beyonic->request()->create($values);
/**
 * Make a Response call i.e access the \Beyonic\Collection\Response object
 * Through this one instance
 */
 $beyonic->response()->getAll();
 /**
 * Make a call to Accounts i.e access the \Beyonic\Collection\Account object
 * Through this one instance
 */
 $beyonic->account()->get(23343);
 /**
 * Make a call to Contacts i.e access the \Beyonic\Collection\Contact object
 * Through this one instance
 */
 $beyonic->contact()->getAll();
 /**
 * Make a call to a Collection i.e access the \Beyonic\Collection\Collection object
 * Through this one instance
 */
 $beyonic->collection()->getAll();
 /**
 * Make a Transaction i.e access the \Beyonic\Collection\Transaction object
 * Through this one instance
 */
 $beyonic->transaction()->getAll();
 /**
 * Make a WebHook i.e access the \Beyonic\Collection\WebHook object
 * Through this one instance
 */
 $beyonic->webHook()->get(47737);

 ```

 ## **Examples for a static object**

 ```php

 use Beyonic\Beyonic;

require "vendor/autoload.php";

/**
 * Some developers find it easy for them to be able
 * to access api calls with static references of 
 * different classes if known.
 * 
 * There is no problem with this since I just extended the functionality but still
 * a single instance of new \Beyonic\Beyonic(key) or (new \Beyonic\Beyonic())->setApiKey(key)
 * is needed. The rest are optional
 * 
 * Let's see how it works
 */

$beyonic = new Beyonic('840604c20904844jjdjfhdj8747673n43j33k93');
$values = [
    "phonenumber" => '+256702455228',
    "amount" => '500',
    "currency" => "UGX",
    "description" => 'Units Payment',
    "metadata" => ['id' => '58475848kdd', 'appId' => 'Company Details Payment'],
];
/**
 * Make a Payment i.e access the \Beyonic\Collection\Payment object
 * Through this one instance
 */
$payment = \Beyonic\Collection\Payment::create($values);

/**
 * Make a Request i.e access the \Beyonic\Collection\Request object
 * Through this one instance
 */

 $request = \Beyonic\Collection\Request::create($values);
/**
 * Make a Response call i.e access the \Beyonic\Collection\Response object
 * Through this one instance
 */
 $response = \Beyonic\Collection\Response::getAll();
 /**
 * Make a call to Accounts i.e access the \Beyonic\Collection\Account object
 * Through this one instance
 */
 $account = \Beyonic\Collection\Account::get(23343);
 /**
 * Make a call to Contacts i.e access the \Beyonic\Collection\Contact object
 * Through this one instance
 */
 $contact = \Beyonic\Collection\Contact::getAll();
 /**
 * Make a call to a Collection i.e access the \Beyonic\Collection\Collection object
 * Through this one instance
 */
 $collection = \Beyonic\Collection\Collection::getAll();
 /**
 * Make a Transaction i.e access the \Beyonic\Collection\Transaction object
 * Through this one instance
 */
 $transaction = \Beyonic\Collection\Transaction::getAll();
 /**
 * Make a WebHook i.e access the \Beyonic\Collection\WebHook object
 * Through this one instance
 */
 $webHook = \Beyonic\Collection\WebHook::get(47737);