<?php
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
    "phonenumber" => '+256702880228',
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