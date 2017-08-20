<?php

namespace Mpwar\DataMiner\Test\Infrastructure;

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
use Mpwar\Test\Infrastructure\Stub;

class DocumentStub extends Stub
{
    public static function random()
    {
        return self::create(
            DocumentIdStub::random(),
            SourceStub::random(),
            LanguageStub::random(),
            KeywordCollectionStub::random(),
            AuthorStub::random(),
            LinkCollectionStub::random(),
            HashtagCollectionStub::random(),
            TextCollectionStub::random(),
            ImageCollectionStub::random(),
            CreatedAtStub::random()
        );
    }

    public static function create(
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
        return new Document(
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
    }

    public static function customKeywordText(string $keyword, string $text)
    {
        return self::create(
            DocumentIdStub::random(),
            SourceStub::random(),
            LanguageStub::random(),
            KeywordCollectionStub::create(KeywordStub::create($keyword)),
            AuthorStub::random(),
            LinkCollectionStub::random(),
            HashtagCollectionStub::random(),
            TextCollectionStub::create(TextStub::create($text)),
            ImageCollectionStub::random(),
            CreatedAtStub::random()
        );
    }
}
