<?php

namespace Cqrs;

use Cqrs\Todo\TodoWasMarkedAsDone;
use Cqrs\Todo\TodoWasPosted;
use Cqrs\Todo\TodoWasReopened;

class TodoProjector
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $table = 'todo';

    public function onTodoWasPosted(TodoWasPosted $event) : void
    {
        $this->connection->insert(
            $this->table,
            [
                'id' => $event->todoId()->toString(),
                'assignee_id' => $event->assigneeId()->toString(),
                'text' => $event->text(),
                'status' => $event->todoStatus()->toString(),
            ]
        );
    }

    public function onTodoWasMarkedAsDone(TodoWasMarkedAsDone $event) : void
    {
        $this->connection->update(
            $this->table,
            [
                'id' => $event->todoId()->toString(),
                'status' => $event->newStatus()->toString()
            ]
        );
    }

    public function onTodoWasReopened(TodoWasReopened $event) : void
    {
        $this->connection->update(
            $this->table,
            [
                'id' => $event->todoId()->toString(),
                'status' => $event->totoStatus()->toString()
            ]
        );
    }
}