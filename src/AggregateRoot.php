<?php

namespace Cqrs;

use ArrayIterator;

abstract class AggregateRoot
{
    protected $version = 0;

    protected $recordedEvents = [];

    public function getEvents() : ArrayIterator
    {
        return new ArrayIterator($this->recordedEvents);
    }

    public static function reconstituteFromHistory(\Iterator $historyEvents) : self
    {
        $instance = new static();
        $instance->replay($historyEvents);

        return $instance;
    }

    protected function replay(\Iterator $historyEvents) : void
    {
        foreach ($historyEvents as $event) {
            $this->recordThat($event);
        }
    }

    protected function recordThat(AggregateChanged $event) : void
    {
        $this->version += 1;
        $this->recordedEvents[] = $event->withVersion($this->version);

        $this->apply($event);
    }

    protected function apply(AggregateChanged $event) : void
    {
        $handler = $this->determineEventHandlerMethodFor($event);

        if (!method_exists($this, $handler)) {
            throw new \RuntimeException(
                sprintf(
                    'Missing event [%s] handler method [%s] for aggregate root [%s]',
                    get_class($event),
                    $handler,
                    get_class($this)
                )
            );
        }

        $this->{$handler}($event);
    }

    abstract protected function determineEventHandlerMethodFor(AggregateChanged $event);
}