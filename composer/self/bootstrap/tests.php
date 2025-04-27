<?php


foreach (\glob(__DIR__ . '/../illuminate/*/tests.php') as $file) {
  require_once $file;
}
