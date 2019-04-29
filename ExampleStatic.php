<?php
use Beyonic\Beyonic;

require "vendor/autoload.php";

/**
 * Some developers find it easy for them to be able
 * to access api calls with static references of 
 * different class if known.
 * 
 * There is no problem if this since I just extended the functionality but still
 * a single instance of new \Beyonic\Beyonic(key) or (new \Beyonic\Beyonic())->setApiKey(key)
 * is needed. The rest are optional
 * 
 * Let's see how it works
 */

$beyonic = new Beyonic('840604c20904844jjdjfhdj8747673n43j33k93');
$values = [
    "phonenumber" => '+256702880228',
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