<?php

require_once 'vendor/autoload.php';


use \Cqrs\StreamName;
use \Cqrs\Stream;
use \Cqrs\Todo\Todo;
use \Cqrs\Todo\TodoId;
use \Cqrs\User\UserId;

$streamName = new StreamName('todo');

// TodoWasPosted
$todo = new Todo();
$todo->post(
    'Text 1',
    new UserId('u1'),
    new TodoId('t1')
);

// DeadlineWasAddedToTodo
$todo->addDeadline(new DateTime('2010-10-10 10:10:10'));

// TodoWasMarkedAsDone
$todo->markAsDone();

// TodoWasReopened
$todo->reopenTodo();

// TodoWasMarkedAsDone
$todo->markAsDone();

//FIXME Todo, is missing add the events to event store.

$events = new ArrayIterator(
    [
        $todoWasPosted,
        $deadlineWasAddedToTodo,
        $todoWasMarkedAsDone
    ]
);

$eventStore->beginTransaction();
$eventStore->create(new Stream($streamName, $events));
$eventStore->commit();