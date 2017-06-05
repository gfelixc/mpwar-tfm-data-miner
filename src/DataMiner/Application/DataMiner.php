<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\EventDispatcher;
use Mpwar\DataMiner\Domain\Keyword\KeywordsRepository;
use Mpwar\DataMiner\Domain\Keyword\KeywordWasRetrievedEvent;

class DataMiner
{
    private $keywordsRepository;

    public function __construct(
        KeywordsRepository $keywordsRepository,
        EventDispatcher $eventDispatcher
    ) {
        $this->keywordsRepository = $keywordsRepository;
        $this->eventDispatcher    = $eventDispatcher;
    }

    public function execute()
    {
        $keywordsList = $this->keywordsRepository->all();

        foreach ($keywordsList as $keyword) {
            $this->eventDispatcher->dispatch(
                KeywordWasRetrievedEvent::NAME,
                new KeywordWasRetrievedEvent($keyword)
            );
        }
    }
}
