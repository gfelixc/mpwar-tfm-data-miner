<?php

namespace Mpwar\DataMiner\Application\Listeners;

use Mpwar\DataMiner\Application\FindKeyword;
use Mpwar\DataMiner\Application\KeywordWasRetrievedEvent;

class KeywordWasRetrievedEventListener
{

    /**
     * @var FindKeyword
     */
    private $findKeyword;

    public function __construct(FindKeyword $findKeyword)
    {

        $this->findKeyword = $findKeyword;
    }

    public function onKeywordRetrieved(KeywordWasRetrievedEvent $event): void
    {
        $this->findKeyword->find($event->keyword());
    }
}
