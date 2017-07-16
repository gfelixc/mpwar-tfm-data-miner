<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\Keyword\KeywordsRepository;

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
