<?php

namespace Cqrs\Todo;

class TodoId
{

    /**
     * @var string
     */
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function toString() : string
    {
        return $this->id;
    }
}