<?php

namespace Cqrs\Todo;

use Cqrs\AggregateChanged;
use Cqrs\User\UserId;

class TodoWasPosted extends AggregateChanged
{

    /**
     * @var TodoId
     */
    private $todoId;

    /**
     * @var UserId
     */
    private $assigneeId;

    /**
     * @var TodoStatus
     */
    private $status;

    /**
     * @var string
     */
    private $text;

    public static function byUser(
        UserId $assigneeId,
        $text,
        TodoId $todoId,
        TodoStatus $status
    ) : self {

        $self = new self();
        $self->assigneeId = $assigneeId;
        $self->text = $text;
        $self->todoId = $todoId;
        $self->status = $status;

        return $self;
    }

    public function todoId(): TodoId
    {
        return $this->todoId;
    }

    public function assigneeId(): UserId
    {
        return $this->assigneeId;
    }

    public function todoStatus(): TodoStatus
    {
        return $this->status;
    }

    public function text(): string
    {
        return $this->text;
    }
}