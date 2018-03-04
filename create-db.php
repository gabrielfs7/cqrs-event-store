<?php

require_once 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$db = __DIR__ . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'db.sqlite';

if (file_exists($db)) {
    unlink($db);
}

touch($db);

$connection = new \Cqrs\Connection();
$connection->migrate('db-scheme.sqlite');

echo PHP_EOL . 'Database created! :)' . PHP_EOL . PHP_EOL;