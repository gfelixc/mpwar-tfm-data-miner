<?php

namespace Mpwar\DataMiner\Infrastructure\Application;

use Mpwar\DataMiner\Application\EventDispatcher;
use Mpwar\DataMiner\Application\KeywordWasRetrievedEvent;
use Mpwar\DataMiner\Application\Listeners\KeywordWasRetrievedEventListener;
use Pimple\Container;


class InMemoryEventDispatcher implements EventDispatcher
{
    private $listeners;

    public function __construct(Container $app)
    {
        $this->listeners = [];

        $this->addListener(
            KeywordWasRetrievedEvent::NAME,
            [
                new KeywordWasRetrievedEventListener($app['application.service.twitter']),
                'onKeywordRetrieved'
            ]

        );
    }


    public function dispatch($eventName, $data)
    {

        echo 'Dispatching event:' . $eventName . "\n";
        if(!key_exists($eventName, $this->listeners)){
            return;
        }
        
        list($class, $method) = $this->listeners[$eventName];

        $class->$method($data);
    }

    private function addListener($string, $array)
    {
        $this->listeners[$string] = $array;
    }
}