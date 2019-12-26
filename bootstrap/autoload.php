<?php

use WJS\API\Loader;

$defaultLoader = require __DIR__ . '/../vendor/autoload.php';
$loader = new Loader($defaultLoader);
$defaultLoader->unregister();
spl_autoload_register([$loader, 'loadClass']);
