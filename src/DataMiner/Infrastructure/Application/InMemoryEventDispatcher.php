<?php

namespace Mpwar\DataMiner\Infrastructure\Application;

use Mpwar\DataMiner\Application\EventDispatcher;
use Pimple\Container;

class InMemoryEventDispatcher implements EventDispatcher
{
    private $listeners;

    public function __construct(Container $app)
    {
        $this->listeners = [];
    }

    public function addListener($string, $array)
    {
        $this->listeners[$string] = $array;
    }

    public function dispatch($eventName, $data)
    {
        if (!key_exists($eventName, $this->listeners)) {
            return;
        }

        list($class, $method) = $this->listeners[$eventName];

        $class->$method($data);
    }
}
