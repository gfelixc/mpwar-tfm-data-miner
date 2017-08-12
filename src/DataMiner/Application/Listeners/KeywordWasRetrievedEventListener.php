<?php

namespace Mpwar\DataMiner\Application\Listeners;

use Mpwar\DataMiner\Application\CommandHandler\FindKeyword;
use Mpwar\DataMiner\Domain\Keyword\KeywordWasRetrievedEvent;

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
