<?php

namespace Cqrs\Todo;

class TodoStatus
{

    const OPEN = 'open';
    const DONE = 'done';

    /**
     * @var string
     */
    private $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public static function open() : self
    {
        return new self(self::OPEN);
    }

    public function isDone() : bool
    {
        return $this->status == self::DONE;
    }

    public function toString() : string
    {
        return $this->status;
    }
}