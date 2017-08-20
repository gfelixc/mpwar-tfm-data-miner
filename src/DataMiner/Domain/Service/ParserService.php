<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\Document;
use Mpwar\DataMiner\Domain\Keyword;

interface ParserService
{
    public function parse(ServiceRecord $record, Keyword $searchedKeyword): Document;
}
