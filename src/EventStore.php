<?php

namespace Cqrs;

class EventStore
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var Stream
     */
    private $stream;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function beginTransaction() : void
    {
        $this->connection->beginTransaction();
    }

    public function create(Stream $stream) : void
    {
        $this->stream = $stream;
    }

    public function commit()
    {
        try {
            /** @var AggregateChanged $event */
            foreach ($this->stream->getEvents() as $event) {
                $this->connection->insert(
                    'event',
                    [
                        'name' => get_class($event),
                        'stream_name' => $this->stream->getStreamName()->name(),
                        'version' => $event->version(),
                        'requested_at' => date('Y-m-d H:i:s'),
                        'body' => serialize($event)
                    ]
                );
            }

            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}