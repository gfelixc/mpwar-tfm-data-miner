<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\Keyword;

interface FinderService
{

    public function find(Keyword $keyword): ServiceRecordsCollection;
}
