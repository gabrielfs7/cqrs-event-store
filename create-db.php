<?php

require_once 'vendor/autoload.php';

$connection = new \Cqrs\Connection();
$connection->migrate('db-scheme.sqlite');

echo PHP_EOL . 'Database created! :)' . PHP_EOL . PHP_EOL;