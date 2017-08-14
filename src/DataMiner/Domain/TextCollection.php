<?php

namespace Mpwar\DataMiner\Domain;

use AntPack\DataTypes\Common\ArrayCollection;

class TextCollection extends ArrayCollection
{

    protected function typeOfCollection(): string
    {
        return Text::class;
    }
}
