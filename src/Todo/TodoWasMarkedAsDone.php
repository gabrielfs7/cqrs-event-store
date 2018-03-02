<?php

namespace Cqrs\Todo;

use Cqrs\AggregateChanged;

class TodoWasMarkedAsDone extends AggregateChanged
{

    /**
     * @var TodoStatus
     */
    private $newStatus;

    /**
     * @var TodoId
     */
    private $todoId;

    public function __construct(TodoId $todoId, TodoStatus $newStatus)
    {
        $this->todoId = $todoId;
        $this->newStatus = $newStatus;
    }

    public function todoId() : TodoId
    {
        return $this->todoId();
    }

    public function newStatus() : TodoStatus
    {
        return $this->newStatus;
    }
}