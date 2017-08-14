<?php

namespace Mpwar\DataMiner\Domain;

use AntPack\DataTypes\Common\ArrayCollection;

class LinkCollection extends ArrayCollection
{

    protected function typeOfCollection(): string
    {
        return Link::class;
    }
}
