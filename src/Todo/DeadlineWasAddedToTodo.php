<?php

namespace Cqrs\Todo;

use Cqrs\AggregateChanged;

use DateTime;

class DeadlineWasAddedToTodo extends AggregateChanged
{

    /**
     * @var DateTime
     */
    private $deadline;

    /**
     * @var TodoId
     */
    private $todoId;

    public static function withDeadline(TodoId $todoId, DateTime $deadline) : self
    {
        $self = new self();
        $self->todoId = $todoId;
        $self->deadline = $deadline;

        return $self;
    }

    public function todoId() : TodoId
    {
        return $this->todoId();
    }

    public function deadline() : DateTime
    {
        return $this->deadline;
    }
}