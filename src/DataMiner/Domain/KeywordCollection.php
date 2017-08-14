<?php

namespace Mpwar\DataMiner\Domain;

use AntPack\DataTypes\Common\ArrayCollection;

class KeywordCollection extends ArrayCollection
{

    protected function typeOfCollection(): string
    {
        return Keyword::class;
    }
}
