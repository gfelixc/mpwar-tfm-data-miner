<?php

namespace Mpwar\DataMiner\Infrastructure\Application;

use Mpwar\DataMiner\Application\EventDispatcher;
use Mpwar\DataMiner\Application\Listeners\KeywordWasRetrievedEventListener;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyComponentEventDispatcher;

class SymfonyEventDispatcher extends SymfonyComponentEventDispatcher implements EventDispatcher
{
    public function __construct(Container $app)
    {
        $this->addListener(
            'keyword.retrieved',
            [
                new KeywordWasRetrievedEventListener($app['application.service.twitter']),
                'find'
            ]

        );
    }
}
