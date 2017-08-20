<?php

namespace Mpwar\DataMiner\Domain\Service;

use AntPack\DataTypes\Common\ArrayCollection;

class ServiceRecordsCollection extends ArrayCollection
{

    protected function typeOfCollection(): string
    {
        return ServiceRecord::class;
    }
}
