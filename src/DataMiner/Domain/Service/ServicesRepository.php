<?php

namespace Mpwar\DataMiner\Domain\Service;

interface ServicesRepository
{

    public function lastVisitWithService($keyword, $service);
}
