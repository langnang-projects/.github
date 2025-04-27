<?php

$app = require_once __DIR__ . '/bootstrap/app.php';

if (!file_exists(__DIR__ . '/.env')) {
  file_exists('./install.php') ? header('Location: install.php') : print ('Missing Config File');
}

var_dump($app);
$app->_run();

return $app;
