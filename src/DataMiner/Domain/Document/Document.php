<?php

namespace Mpwar\DataMiner\Domain\Document;

use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\ServiceName;

class Document
{
    private $service;
    private $id;
    private $keyword;
    private $content;

    public function __construct(
        DocumentId $id,
        ServiceName $service,
        Keyword $keyword,
        DocumentContent $content
    ) {
        $this->id      = $id;
        $this->service  = $service;
        $this->keyword = $keyword;
        $this->content = $content;
    }
}
