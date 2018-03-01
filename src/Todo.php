<?php


class Todo extends AggregateRoot
{

    protected function whenTodoWasPosted(TodoWasReopened $event)
    {
        $this->todoId = $event->todoId();
        $this->assigneeId = $event->assigneeId();
        $this->text = $event->text();
        $this->status = $event->todoStatus();
    }

    protected function whenTodoWasMarkedAsDone(TodoWasMarkedAsDone $event)
    {
        $this->status = $event->newStatus();
    }

    public static function post($text, UserId $assigneeId, TodoId $todoId)
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

    public function reopenTodo()
    {
        if (!$this->status->isDone()) {
            throw \Exception\CannotReopenTodo::notMarkedDone($this);
        }

        $this->recordThat(
            TodoWasReopened::withStatus(
                $this->todoId,
                TodoStatus::fromString(TodoStatus::OPEN)
            )
        );
    }
}