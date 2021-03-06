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

    public static function forTodo(TodoId $todoId) : self
    {
        $self = new self();
        $self->todoId = $todoId;
        $self->newStatus = TodoStatus::done();

        return $self;
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