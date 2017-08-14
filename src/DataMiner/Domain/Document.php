<?php

namespace Mpwar\DataMiner\Domain;

use AntPack\DataTypes\Common\Language;

class Document
{
    /**
     * @var DocumentId
     */
    protected $documentId;
    /**
     * @var Source
     */
    protected $source;
    /**
     * @var Language
     */
    protected $language;
    /**
     * @var KeywordCollection
     */
    protected $keywordCollection;
    /**
     * @var Author
     */
    protected $author;
    /**
     * @var LinkCollection
     */
    protected $linkCollection;
    /**
     * @var HashtagCollection
     */
    protected $hashtagCollection;
    /**
     * @var TextCollection
     */
    protected $textCollection;
    /**
     * @var ImageCollection
     */
    protected $imageCollection;
    /**
     * @var CreatedAt
     */
    protected $createdAt;

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
        $this->documentId        = $documentId;
        $this->source            = $source;
        $this->language          = $language;
        $this->keywordCollection = $keywordCollection;
        $this->author            = $author;
        $this->linkCollection    = $linkCollection;
        $this->hashtagCollection = $hashtagCollection;
        $this->textCollection    = $textCollection;
        $this->imageCollection   = $imageCollection;
        $this->createdAt         = $createdAt;
    }

    /**
     * @return DocumentId
     */
    public function documentId(): DocumentId
    {
        return $this->documentId;
    }

    /**
     * @return Source
     */
    public function source(): Source
    {
        return $this->source;
    }

    /**
     * @return Language
     */
    public function language(): Language
    {
        return $this->language;
    }

    /**
     * @return KeywordCollection
     */
    public function keywordCollection(): KeywordCollection
    {
        return $this->keywordCollection;
    }

    /**
     * @return Author
     */
    public function author(): Author
    {
        return $this->author;
    }

    /**
     * @return LinkCollection
     */
    public function linkCollection(): LinkCollection
    {
        return $this->linkCollection;
    }

    /**
     * @return HashtagCollection
     */
    public function hashtagCollection(): HashtagCollection
    {
        return $this->hashtagCollection;
    }

    /**
     * @return TextCollection
     */
    public function textCollection(): TextCollection
    {
        return $this->textCollection;
    }

    /**
     * @return ImageCollection
     */
    public function imageCollection(): ImageCollection
    {
        return $this->imageCollection;
    }

    /**
     * @return CreatedAt
     */
    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

}
