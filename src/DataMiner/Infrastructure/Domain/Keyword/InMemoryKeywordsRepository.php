<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Keyword;

use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Keyword\KeywordsCollection;
use Mpwar\DataMiner\Domain\Keyword\KeywordsRepository;

class InMemoryKeywordsRepository implements KeywordsRepository
{

    public function all(): KeywordsCollection
    {
        return new KeywordsCollection(
            new Keyword('sunscreen'),
            new Keyword('workout')
        );
    }
}
