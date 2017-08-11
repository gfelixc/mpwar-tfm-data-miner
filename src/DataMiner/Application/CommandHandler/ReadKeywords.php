<?php

namespace Mpwar\DataMiner\Application\CommandHandler;

use Mpwar\DataMiner\Application\EventDispatcher;
use Mpwar\DataMiner\Application\KeywordWasRetrievedEvent;
use Mpwar\DataMiner\Domain\Keyword\KeywordsRepository;

class ReadKeywords
{
    private $keywordsRepository;

    public function __construct(
        KeywordsRepository $keywordsRepository,
        EventDispatcher $eventDispatcher
    ) {
        $this->keywordsRepository = $keywordsRepository;
        $this->eventDispatcher    = $eventDispatcher;
    }

    public function execute(): void
    {
        $keywordsList = $this->keywordsRepository->all();

        foreach ($keywordsList as $keyword) {
            $event = new KeywordWasRetrievedEvent($keyword);
            $this->eventDispatcher->dispatch(
                KeywordWasRetrievedEvent::NAME,
                $event
            );
        }
    }
}
