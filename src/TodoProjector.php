<?php


class TodoProjector
{
    public function onTodoWasPosted(TodoWasPosted $event)
    {
        $this->connection->insert(
            Table::TODO,
            [
                'id' => $event->todoId()->toString(),
                'assignee_id' => $event->assigneeId()->toString(),
                'text' => $event->text(),
                'status' => $event->todoStatus()->toString(),
            ]
        );
    }

    public function onTodoWasMarkedAsDone(TodoWasMarkedAsDone $event)
    {
        $this->connection->update(
            Table::TODO,
            [
                'id' => $event->todoId()->toString(),
            ],
            [
                'status' => $event->newStatus()->toString()
            ]
        );
    }
}