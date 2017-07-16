<?php

namespace Mpwar\DataMiner\Domain\Keyword;

interface KeywordsRepository
{

    public function all(): KeywordsCollection;
}
