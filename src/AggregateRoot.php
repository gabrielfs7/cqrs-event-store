<?php


abstract class AggregateRoot
{
    protected $version = 0;

    protected $recordedEvents = [];

    protected static function reconstituteFromHistory(\Iterator $historyEvents)
    {
        $instance = new static();
        $instance->replay($historyEvents);

        return $instance;
    }

    protected function replay(\Iterator $historyEvents)
    {

    }

    protected function recordThat(AggregateChanged $event)
    {
        $this->version += 1;
        $this->recordedEvents[] = $event->withVersion($this->version);

        $this->apply($event);
    }

    protected function apply(AggregateChanged $event)
    {
        $handler = $this->determineEventHandlerMethodFor($event);

        if (!method_exists($this, $handler)) {
            throw new \RuntimeException(
                sprintf(
                    'Missing event handler method %s for aggregate root %s',
                    $handler,
                    get_class($this)
                )
            );
        }

        $this->{$handler}($event);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $event)
    {

    }
}