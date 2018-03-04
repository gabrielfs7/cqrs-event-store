<?php

require_once 'vendor/autoload.php';

use \Cqrs\StreamName;
use \Cqrs\Stream;
use \Cqrs\Todo\Todo;
use \Cqrs\Todo\TodoStatus;
use \Cqrs\Todo\TodoId;
use \Cqrs\User\UserId;
use \Cqrs\Todo\TodoWasPosted;
use \Cqrs\Todo\TodoWasMarkedAsDone;
use \Cqrs\Todo\TodoWasReopened;
use \Cqrs\Todo\DeadlineWasAddedToTodo;
use \Cqrs\EventStore;
use \Cqrs\Connection;

$connection = new Connection();
$eventStore = new EventStore($connection);
$streamName = new StreamName('todo');

$events = new ArrayIterator(
    [
        TodoWasPosted::byUser(
            new UserId('u1'),
            'Text 1',
            new TodoId('t1'),
            TodoStatus::open()
        ),
        DeadlineWasAddedToTodo::withDeadline(
            new TodoId('t1'),
            new DateTime('2010-10-10 10:10:10')
        ),
        TodoWasMarkedAsDone::forTodo(
            new TodoId('t1')
        ),
        TodoWasReopened::withStatus(
            new TodoId('t1'),
            TodoStatus::open()
        ),
        TodoWasMarkedAsDone::forTodo(
            new TodoId('t1')
        ),
    ]
);

/*
 * Whe recover the state of a domain object based in a series of events.
 */
$todo = Todo::reconstituteFromHistory($events);

// TodoWasPosted
$todo = Todo::post(
    'Text 1',
    new UserId('u1'),
    new TodoId('t1')
);

// DeadlineWasAddedToTodo
$todo->addDeadline(new DateTime('2010-10-10 10:10:10'));

//TodoWasMarkedAsDone
$todo->markAsDone();

//TodoWasReopened
$todo->reopenTodo();

//TodoWasMarkedAsDone
$todo->markAsDone();

/*
 * We are saving the events to the database, so it will be applied by the projector,
 * which could be in a different server.
 */
$eventStore->beginTransaction();
$eventStore->create(new Stream($streamName, $todo->getEvents()));
$eventStore->commit();

echo PHP_EOL;
echo PHP_EOL;
echo '--- EVENTS ---';
echo PHP_EOL;
echo PHP_EOL;
var_export($connection->find('event', 1));
echo PHP_EOL;
var_export($connection->find('event', 2));
echo PHP_EOL;
var_export($connection->find('event', 3));
echo PHP_EOL;
var_export($connection->find('event', 4));
echo PHP_EOL;
echo PHP_EOL;