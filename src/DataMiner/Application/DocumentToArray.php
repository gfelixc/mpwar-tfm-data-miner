<?php

namespace Mpwar\DataMiner\Application;

use Mpwar\DataMiner\Domain\Document;
use Mpwar\DataMiner\Domain\Hashtag;
use Mpwar\DataMiner\Domain\HashtagCollection;
use Mpwar\DataMiner\Domain\Image;
use Mpwar\DataMiner\Domain\ImageCollection;
use Mpwar\DataMiner\Domain\Link;
use Mpwar\DataMiner\Domain\LinkType;
use Mpwar\DataMiner\Domain\Text;
use Mpwar\DataMiner\Domain\TextCollection;

class DocumentToArray implements DocumentTransformer
{
    public function transform(Document $document): array
    {
        $keyword = ($document->keywordCollection()[0]) ? $document->keywordCollection()[0]->value(): '';
        $content = ($document->textCollection()[0]) ? $document->textCollection()[0]->value() : '';

        $relatedLinks = [];
        foreach ($document->linkCollection() as $currentLink) {
            /** @var Link $currentLink */
            if ($currentLink->type() == LinkType::RELATED) {
                $relatedLinks[] = $currentLink->url();
            }
            if ($currentLink->type() == LinkType::DIRECT) {
                /** @var Link $directLink */
                $directLink = $currentLink;
            }
        }

        return [
            "source"          => $document->source()->name(),
            "source_id"       => $document->source()->id(),
            "keyword"         => $keyword,
            "author"          => $document->author()->name(),
            "author_location" => $document->author()->location(),
            "content"         => $content,
            "created_at"      => $document->createdAt()->value(),
            "metadata"        => [
                "language" => $document->language()->value(),
                "source" => [
                    "name" => $document->source()->name(),
                    "id" => $document->source()->id()
                ],
                "author" => [
                    "name" => $document->author()->name(),
                    "location" => $document->author()->location()
                ],
                "links" => [
                    "direct" => (isset($directLink)) ? $directLink->url()->value() : "",
                    "related" => $relatedLinks
                ],
                "hashtags" => $this->getHashtags($document->hashtagCollection()),
                "texts" => $this->getTexts($document->textCollection()),
                "images" => $this->getImages($document->imageCollection())
            ],
        ];
    }

    private function getImages(ImageCollection $imageCollection): array
    {
        $images = [];
        foreach ($imageCollection as $currentImage) {
            /** @var Image $currentImage */
            $images[] = [
                "url"  => $currentImage->url()->value(),
                "text" => $currentImage->text()->value()
            ];
        }

        return $images;
    }

    /**
     * @param HashtagCollection $hashtagCollection
     * @return array
     */
    private function getHashtags(HashtagCollection $hashtagCollection): array
    {
        $hashtags = [];
        foreach ($hashtagCollection as $currentHashtag) {
            /** @var Hashtag $currentHashtag */
            $hashtags[] = $currentHashtag->value();
        }

        return $hashtags;
    }

    /**
     * @param TextCollection $textCollection
     * @return array
     */
    private function getTexts(TextCollection $textCollection): array
    {
        $texts = [];
        foreach ($textCollection as $currentText) {
            /** @var Text $currentText */
            $texts[] = $currentText->value();
        }

        return $texts;
    }
}
