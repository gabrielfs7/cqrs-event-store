<?php

namespace Cqrs;

class AggregateChanged
{

    /**
     * @var string
     */
    protected $version;

    public function withVersion(string $version) : self
    {
        $this->version = $version;

        return $this;
    }
}