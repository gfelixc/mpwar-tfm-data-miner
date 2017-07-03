<?php

namespace Mpwar\DataMiner\Domain\Service;

use Mpwar\DataMiner\Domain\Keyword\Keyword;

interface ServicesRepository
{

    public function lastVisitWithService(Keyword $keyword, ServiceName $service);

    public function registerVisit(ServiceName $serviceName, $lastVisitFlag): void;
}
