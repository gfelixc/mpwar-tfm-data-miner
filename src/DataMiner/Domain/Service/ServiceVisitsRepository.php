<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\Keyword\Keyword;

interface ServiceVisitsRepository
{

    public function lastByKeyword(Keyword $keyword, ServiceName $service): ?Visit;

    public function registerVisit(Visit $visit): void;
}
