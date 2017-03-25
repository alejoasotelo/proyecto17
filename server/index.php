<?php
require_once __DIR__.'/vendor/autoload.php';

spl_autoload_register(function ($classname) {

	if (strpos($classname, 'Controller') !== false) {
		require (__DIR__ . '/'. $classname . ".php");		
	} else {
		require (__DIR__.'classes/' . $classname . ".php");
	}
});

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Controllers\SessionController;

$config = array();
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['pass']   = "";
$config['db']['dbname'] = "proyecto17";

$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();
$container['db'] = function ($c) {
	$db = $c['settings']['db'];
	$pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
		$db['user'], $db['pass']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $pdo;
};

$container['SessionController'] = function($c) {
	$db = $c->get("db");
	return new SessionController($db);
};

$app->group('/session', SessionController::class);
//$app->get('/', \Controllers\SessionController::class);

$app->run();