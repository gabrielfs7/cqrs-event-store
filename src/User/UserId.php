<?php

namespace Cqrs\User;

class UserId
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function toString() : string
    {
        return $this->id;
    }
}