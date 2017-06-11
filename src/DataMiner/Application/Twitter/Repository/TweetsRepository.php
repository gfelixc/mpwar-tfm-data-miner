<?php

namespace Mpwar\DataMiner\Application\Twitter\Repository;

interface TweetsRepository
{

    public function findKeywordSince($value, $since);
}
