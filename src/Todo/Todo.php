<?php

namespace Cqrs\Todo;

use Cqrs\AggregateChanged;
use Cqrs\AggregateRoot;
use Cqrs\User\UserId;
use Cqrs\Exception\CannotReopenTodo;

class Todo extends AggregateRoot
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

    public function post($text, UserId $assigneeId, TodoId $todoId) : self
    {
        $self = new self();
        $self->assertText($text);
        $self->recordThat(
            TodoWasPosted::byUser(
                $assigneeId,
                $text,
                $todoId,
                TodoStatus::open()
            )
        );

        return $self;
    }

    public function reopenTodo() : void
    {
        if (!$this->status->isDone()) {
            throw CannotReopenTodo::notMarkedDone($this);
        }

        $this->recordThat(
            TodoWasReopened::withStatus(
                $this->todoId,
                TodoStatus::open()
            )
        );
    }

    protected function whenTodoWasPosted(TodoWasPosted $event) : void
    {
        $this->todoId = $event->todoId();
        $this->assigneeId = $event->assigneeId();
        $this->text = $event->text();
        $this->status = $event->todoStatus();
    }

    protected function whenTodoWasMarkedAsDone(TodoWasMarkedAsDone $event) : void
    {
        $this->status = $event->newStatus();
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $event) : string
    {
        if ($event instanceof TodoWasMarkedAsDone) {
            return 'whenTodoWasMarkedAsDone';
        }

        if ($event instanceof TodoWasPosted) {
            return 'whenTodoWasPosted';
        }

        return '';
    }

    private function assertText($text) : void
    {
        if (is_string($text)) {
            throw new \InvalidArgumentException('Invalid todo text');
        }
    }
}