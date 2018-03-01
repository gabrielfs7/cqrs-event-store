<?php

class AggregateChanged
{

    protected $version;

    /**
     * @param $version
     * @return $this
     */
    public function withVersion($version)
    {
        $this->version = $version;

        return $this;
    }
}