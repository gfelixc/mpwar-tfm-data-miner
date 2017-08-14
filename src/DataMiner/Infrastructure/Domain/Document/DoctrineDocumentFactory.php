<?php

namespace Mpwar\DataMiner\Infrastructure\Domain\Document;

use AntPack\DataTypes\Common\Language;
use Mpwar\DataMiner\Domain\Author;
use Mpwar\DataMiner\Domain\CreatedAt;
use Mpwar\DataMiner\Domain\Document;
use Mpwar\DataMiner\Domain\DocumentFactory;
use Mpwar\DataMiner\Domain\DocumentId;
use Mpwar\DataMiner\Domain\Hashtag;
use Mpwar\DataMiner\Domain\HashtagCollection;
use Mpwar\DataMiner\Domain\Image;
use Mpwar\DataMiner\Domain\ImageCollection;
use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\KeywordCollection;
use Mpwar\DataMiner\Domain\Link;
use Mpwar\DataMiner\Domain\LinkCollection;
use Mpwar\DataMiner\Domain\LinkType;
use Mpwar\DataMiner\Domain\LinkUrl;
use Mpwar\DataMiner\Domain\Source;
use Mpwar\DataMiner\Domain\Text;
use Mpwar\DataMiner\Domain\TextCollection;

class DoctrineDocumentFactory implements DocumentFactory
{

    public function createDocument(
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
    ): Document {
        return new DoctrineDocument(
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

    public function createDocumentId(string $id): DocumentId
    {
        return DocumentId::fromString($id);
    }

    public function createSource($id, string $name): Source
    {
        return new Source($id, $name);
    }

    public function createLanguage(string $language): Language
    {
        return new Language($language);
    }

    public function createKeywordCollection(...$keyword): KeywordCollection
    {
        return new KeywordCollection(...$keyword);
    }

    public function createKeyword(string $keyword): Keyword
    {
        return new Keyword($keyword);
    }

    public function createAuthor(string $author, string $location): Author
    {
        return new Author($author, $location);
    }

    public function createLinkCollection(...$link): LinkCollection
    {
        return new LinkCollection(...$link);
    }

    public function createLink(string $type, string $url): Link
    {
        return new Link(new LinkType($type), new LinkUrl($url));
    }

    public function createHashtagCollection(...$hashtag): HashtagCollection
    {
        return new HashtagCollection(...$hashtag);
    }

    public function createHashtag(string $hashtag): Hashtag
    {
        return new Hashtag($hashtag);
    }

    public function createTextCollection(...$text): TextCollection
    {
        return new TextCollection(...$text);
    }

    public function createText(string $text): Text
    {
        return new Text($text);
    }

    public function createImageCollection(...$image): ImageCollection
    {
        return new ImageCollection(...$image);
    }

    public function createImage(string $url, string $text): Image
    {
        return new Image(new LinkUrl($url), new Text($text));
    }

    public function createCreatedAt(string $date): CreatedAt
    {
        return new CreatedAt($date);
    }
}
