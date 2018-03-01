<?php

class Stream
{
    /**
     * @var StreamName
     */
    private $streamName;

    /**
     * @var \Iterator
     */
    private $events;

    public function __construct(StreamName $streamName, \Iterator $events)
    {
        $this->streamName = $streamName;
        $this->events = $events;
    }

    /**
     * @return StreamName
     */
    public function getStreamName()
    {
        return $this->streamName;
    }

    /**
     * @return Iterator
     */
    public function getEvents()
    {
        return $this->events;
    }


}