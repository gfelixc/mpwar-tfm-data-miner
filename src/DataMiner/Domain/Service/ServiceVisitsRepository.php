<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\Keyword;

interface ServiceVisitsRepository
{

    public function lastVisitWithService(Keyword $keyword, ServiceName $service): ?ServiceVisit;

    public function registerVisit(ServiceVisit $visit): void;
}
