<?php

namespace Mpwar\DataMiner\Domain;

use AntPack\DataTypes\Common\ArrayCollection;

class HashtagCollection extends ArrayCollection
{

    protected function typeOfCollection(): string
    {
        return Hashtag::class;
    }
}
