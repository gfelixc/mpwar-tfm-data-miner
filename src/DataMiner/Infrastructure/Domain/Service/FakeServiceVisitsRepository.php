<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Service;

use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\Service\ServiceName;
use Mpwar\DataMiner\Domain\Service\ServiceVisit;
use Mpwar\DataMiner\Domain\Service\ServiceVisitsRepository;

class FakeServiceVisitsRepository implements ServiceVisitsRepository
{

    public function lastVisitWithService(
        Keyword $keyword,
        ServiceName $service
    ): ?ServiceVisit
    {
        return null;
    }

    public function registerVisit(ServiceVisit $visit): void
    {
        return;
    }
}
