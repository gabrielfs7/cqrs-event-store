<?php

namespace Cqrs\Exception;

use Cqrs\AggregateRoot;

class CannotReopenTodo extends \Exception
{

    public static function notMarkedDone(AggregateRoot $aggregateRoot) : self
    {
        return new self('Nor marked as done ' . get_class($aggregateRoot));
    }
}