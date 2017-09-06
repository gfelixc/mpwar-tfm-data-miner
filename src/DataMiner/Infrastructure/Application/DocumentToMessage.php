<?php

namespace Mpwar\DataMiner\Infrastructure\Application;

use Mpwar\DataMiner\Application\DocumentTransformer;
use Mpwar\DataMiner\Domain\Document;
use Mpwar\DataMiner\Domain\Hashtag;
use Mpwar\DataMiner\Domain\HashtagCollection;
use Mpwar\DataMiner\Domain\Image;
use Mpwar\DataMiner\Domain\ImageCollection;
use Mpwar\DataMiner\Domain\Link;
use Mpwar\DataMiner\Domain\LinkType;
use Mpwar\DataMiner\Domain\Text;
use Mpwar\DataMiner\Domain\TextCollection;

class DocumentToMessage implements DocumentTransformer
{
    const ENVELOPE_EVENT_NAME = 'RawDocumentWasStored';

    public function transform(Document $document): string
    {
        $keyword = ($document->keywordCollection()[0]) ? $document->keywordCollection()[0]->value() : '';
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

        $message = $this->addEnvelope(
            [
                "source"          => $document->source()->name(),
                "source_id"       => $document->source()->id(),
                "keyword"         => $keyword,
                "author"          => $document->author()->name(),
                "author_location" => $document->author()->location(),
                "content"         => $content,
                "created_at"      => $document->createdAt()->value(),
                "metadata"        => [
                    "language" => $document->language()->value(),
                    "source"   => [
                        "name" => $document->source()->name(),
                        "id"   => $document->source()->id()
                    ],
                    "author"   => [
                        "name"     => $document->author()->name(),
                        "location" => $document->author()->location()
                    ],
                    "links"    => [
                        "direct"  => (isset($directLink)) ? $directLink->url()->value() : "",
                        "related" => $relatedLinks
                    ],
                    "hashtags" => $this->getHashtags($document->hashtagCollection()),
                    "texts"    => $this->getTexts($document->textCollection()),
                    "images"   => $this->getImages($document->imageCollection())
                ],
            ]
        );

        return $this->encode($message);
    }

    private function addEnvelope(array $data): array
    {
        return [
            'eventName'  => self::ENVELOPE_EVENT_NAME,
            'occurredOn' => (new \DateTime())->format(DATE_ATOM),
            'data'       => $data
        ];
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

    private function encode(array $message): string
    {
        return json_encode($message);
    }
}
