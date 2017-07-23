<?php

namespace Mpwar\DataMiner\Domain\Document;

use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\ServiceName;

interface DocumentsFactory
{

    public function build(
        ServiceName $serviceName,
        Keyword $keyword,
        string $value
    ): Document;
}
