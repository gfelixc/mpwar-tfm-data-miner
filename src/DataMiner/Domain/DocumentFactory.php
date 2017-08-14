<?php

namespace Mpwar\DataMiner\Domain;

use AntPack\DataTypes\Common\Language;

interface DocumentFactory
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
    ): Document;

    public function createDocumentId(string $id): DocumentId;
    public function createSource($id, string $name): Source;
    public function createLanguage(string $language): Language;
    public function createKeywordCollection(... $keyword): KeywordCollection;
    public function createKeyword(string $keyword): Keyword;
    public function createAuthor(string $author, string $location): Author;
    public function createLinkCollection(...$link): LinkCollection;
    public function createLink(string $type, string $url): Link;
    public function createHashtagCollection(... $hashtag): HashtagCollection;
    public function createHashtag(string $hashtag): Hashtag;
    public function createTextCollection(... $text): TextCollection;
    public function createText(string $text): Text;
    public function createImageCollection(...$image): ImageCollection;
    public function createImage(string $url, string $text): Image;
    public function createCreatedAt(string $date): CreatedAt;
}
