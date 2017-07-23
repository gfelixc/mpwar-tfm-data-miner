<?php

namespace Mpwar\DataMiner\Domain\Document;

use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\ServiceName;

class Document
{
    protected $service;
    protected $id;
    protected $keyword;
    protected $content;

    public function __construct(
        DocumentId $id,
        ServiceName $service,
        Keyword $keyword,
        DocumentContent $content
    ) {
        $this->id      = $id;
        $this->service = $service;
        $this->keyword = $keyword;
        $this->content = $content;
    }

    public function service(): ServiceName
    {
        return $this->service;
    }

    public function id(): DocumentId
    {
        return $this->id;
    }

    public function keyword(): Keyword
    {
        return $this->keyword;
    }

    public function content(): DocumentContent
    {
        return $this->content;
    }
}
