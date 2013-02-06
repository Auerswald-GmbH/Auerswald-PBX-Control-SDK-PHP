<?php

/**
 * A bootstrap for the Auerswald PBX-Control API
 * 
 * @link https://github.com/smarkwardt/Auerswald-PBX-Control-SDK-PHP
 * @link http://www.smarkwardt.de/
 * @link http://www.auerswald.de/
 */

// Set error reporting
error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('html_errors', 'On');

// Set Content-Type
header("Content-Type: text/plain; charset=utf-8");

// Register a simple autoload function
spl_autoload_register(function($class){
	$class = str_replace('\\', '/', $class);
    require_once(dirname(__FILE__) . '/../src/' . $class . '.php');
});


// Create :: Connection

// Create a new instance of the class PBXDevice
$pbx = new \Auerswald\API\PBX\PBXDevice("http://<address>/", "<username>", "<password>");


// Request :: Information

// Get information about the PBX-Device
if ($info = $pbx->getInfo())
{
	printf("Seriennummer: %s\n", $info->serial);
	printf("Typ: %s\n\n", $info->pbx);
}


// Request :: Phonebook

// Get information about the PBX-Device
if ($phoneBookList = $pbx->getPhoneBook())
{
	foreach ($phoneBookList as $item)
	{
		printf("Name: %s\nNummer: %s\n\n", $item->kwName, $item->kwNr);
	}
}