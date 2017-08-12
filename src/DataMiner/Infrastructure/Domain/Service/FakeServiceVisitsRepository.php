<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Service;

use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\ServiceName;
use Mpwar\DataMiner\Domain\Service\Visit;
use Mpwar\DataMiner\Domain\Service\ServiceVisitsRepository;

class FakeServiceVisitsRepository implements ServiceVisitsRepository
{

    public function lastByKeyword(
        Keyword $keyword,
        ServiceName $service
    ): ?Visit
    {
        return null;
    }

    public function registerVisit(Visit $visit): void
    {
        return;
    }
}
