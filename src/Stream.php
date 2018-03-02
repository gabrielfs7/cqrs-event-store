<?php

namespace Cqrs;

use \Iterator;

class Stream
{
    /**
     * @var StreamName
     */
    private $streamName;

    /**
     * @var Iterator
     */
    private $events;

    public function __construct(StreamName $streamName, Iterator $events)
    {
        $this->streamName = $streamName;
        $this->events = $events;
    }

    public function getStreamName() : StreamName
    {
        return $this->streamName;
    }

    public function getEvents() : Iterator
    {
        return $this->events;
    }


}