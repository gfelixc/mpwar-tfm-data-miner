<?php

namespace Mpwar\DataMiner\Domain;

use AntPack\DataTypes\Common\ArrayCollection;

class ImageCollection extends ArrayCollection
{

    protected function typeOfCollection(): string
    {
        return Image::class;
    }
}
