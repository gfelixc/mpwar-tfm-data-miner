<?php

namespace Mpwar\DataMiner\Domain\Service\Twitter\Repository;

use Mpwar\DataMiner\Domain\Keyword\Keyword;

interface TweetsRepository
{

    public function findKeywordSince(Keyword $keyword, $since): TweetsCollection;
}
