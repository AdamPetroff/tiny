<?php

// Uncomment this line if you must temporarily take down your site for maintenance.
// require __DIR__ . '/.maintenance.php';
define('WWW_DIR',__DIR__);
define('APP_DIR',__DIR__."/../app");
define('WWW_URL','http://'.$_SERVER['HTTP_HOST']);
$container = require __DIR__ . '/../app/bootstrap.php';

$container->getByType('Nette\Application\Application')->run();
