<?php

$streamName = new StreamName('todo');

/*

Event sequence:

TodoWasPosted
DeadlineWasAddedToTodo
TodoWasMarkedAsDone
TodoWasReopened
TodoWasMarkedAsDone

*/


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