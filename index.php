<?php
spl_autoload_register(function($class) {
	require_once("classes" . DIRECTORY_SEPARATOR . $class . ".php");
});

$app = new App();
$app->basePath = __DIR__;
$app->run();
