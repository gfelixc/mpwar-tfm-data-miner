<?php

namespace Mpwar\DataMiner\Domain\Keyword;

use Mpwar\DataMiner\Domain\DataType\ArrayCollection;

class KeywordsCollection extends ArrayCollection
{

    protected function typeOfCollection(): string
    {
        return Keyword::class;
    }
}
