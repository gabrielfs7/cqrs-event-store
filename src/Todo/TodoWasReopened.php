<?php

namespace Cqrs\Todo;

use Cqrs\AggregateChanged;

class TodoWasReopened extends AggregateChanged
{

    /**
     * @var TodoId
     */
    private $todoId;

    /**
     * @var TodoStatus
     */
    private $status;

    public static function withStatus(TodoId $todoId, TodoStatus $todoStatus) : self
    {
        $self = new self();
        $self->todoId = $todoId;
        $self->status = $todoStatus;

        return $self;
    }

    public function todoId(): TodoId
    {
        return $this->todoId;
    }

    public function totoStatus(): TodoStatus
    {
        return $this->status;
    }
}