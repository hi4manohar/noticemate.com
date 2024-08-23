<?php

require( $_SERVER['DOCUMENT_ROOT'] . "/system/startup.php" );

//Registry
$registry = new Registry();

//Request
$request = new Request();
$registry->set('request', $request);

//check if local or live
if( $request->server['SERVER_ADDR'] == '127.0.0.1' ) {
  define('localAccess', true);
  dbConst();
  localDomains();
} else {
  liveDbConst();
  liveDomain();
}

//DB
$db = new mPDO( HOSTNAME, USERNAME, PASS, DATABASE );
$registry->set('db', $db);

//Cookie
$cookie = new Cookie($registry);
$registry->set('cookie', $cookie);

//Response
$response = new Response();
$registry->set('response', $response);

//Encryption
keys();
$encryption = new encryption( COOKIE );
$registry->set('encp', $encryption);

//Input Test
$input_test = new userInput();
$registry->set('inputest', $input_test);

//User
$user = new User($registry);
$registry->set('user', $user);

$document = new document();
$registry->set('document', $document);

//Model
$model = new Model($registry);
$registry->set('model', $model);

//Loader
$loader = new Loader($registry);
$registry->set('loader', $loader);

// Document
$registry->set('document', new Document());

//Language
$registry->set('language', new Language());

?>