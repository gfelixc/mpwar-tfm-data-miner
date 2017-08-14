<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Document;

use AntPack\DataTypes\Common\Language;
use Mpwar\DataMiner\Domain\Author;
use Mpwar\DataMiner\Domain\CreatedAt;
use Mpwar\DataMiner\Domain\Document;
use Mpwar\DataMiner\Domain\DocumentId;
use Mpwar\DataMiner\Domain\HashtagCollection;
use Mpwar\DataMiner\Domain\ImageCollection;
use Mpwar\DataMiner\Domain\KeywordCollection;
use Mpwar\DataMiner\Domain\LinkCollection;
use Mpwar\DataMiner\Domain\Source;
use Mpwar\DataMiner\Domain\TextCollection;

class DoctrineDocument extends Document
{
    private $id;

    public function __construct(
        DocumentId $documentId,
        Source $source,
        Language $language,
        KeywordCollection $keywordCollection,
        Author $author,
        LinkCollection $linkCollection,
        HashtagCollection $hashtagCollection,
        TextCollection $textCollection,
        ImageCollection $imageCollection,
        CreatedAt $createdAt
    ) {
        parent::__construct(
            $documentId,
            $source,
            $language,
            $keywordCollection,
            $author,
            $linkCollection,
            $hashtagCollection,
            $textCollection,
            $imageCollection,
            $createdAt
        );

        $this->id = $documentId;
    }
}
