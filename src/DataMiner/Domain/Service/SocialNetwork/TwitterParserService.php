<?php

namespace Mpwar\DataMiner\Domain\Service\SocialNetwork;

use AntPack\DataTypes\Common\Language;
use DateTime;
use Mpwar\DataMiner\Domain\Document;
use Mpwar\DataMiner\Domain\DocumentFactory;
use Mpwar\DataMiner\Domain\DocumentId;
use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\LinkType;
use Mpwar\DataMiner\Domain\Service\ParserService;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;

class TwitterParserService implements ParserService
{
    const SOURCE_NAME         = 'twitter';
    const CREATED_AT_FORMAT   = "D M d H:i:s O Y";
    const STATUS_URL_TEMPLATE = "https://twitter.com/%s/status/%d";
    /**
     * @var DocumentFactory
     */
    private $documentFactory;

    public function __construct(
        DocumentFactory $documentFactory
    ) {

        $this->documentFactory = $documentFactory;
    }

    public function parse(ServiceRecord $record, Keyword $searchedKeyword): Document
    {
        $recordDecoded = json_decode($record->value());
        $parsedLanguage = $recordDecoded->metadata->iso_language_code;

        $id             = $recordDecoded->id;
        $language       = (Language::isValid($parsedLanguage)) ? $parsedLanguage : Language::UNKNOWN;
        $keywords       = [
            $this->documentFactory()->createKeyword($searchedKeyword->value())
        ];
        $authorName     = $recordDecoded->user->name;
        $authorLocation = $recordDecoded->user->location;
        $directUrl      = sprintf(self::STATUS_URL_TEMPLATE, $recordDecoded->user->screen_name, $id);
        $links = $this->getRelatedLinks($recordDecoded);
        $links[] = $this->documentFactory()->createLink(LinkType::DIRECT, $directUrl);
        $hashtags = $this->getHashtags($recordDecoded);

        $texts = [
            $this->documentFactory()->createText($recordDecoded->text)
        ];
        $images = [
            $this->documentFactory()->createImage($recordDecoded->user->profile_image_url, 'Profile image')
        ];

        $createdAtDateTime = DateTime::createFromFormat(self::CREATED_AT_FORMAT, $recordDecoded->created_at);

        return $this->documentFactory()->createDocument(
            $this->documentFactory()->createDocumentId(DocumentId::new()->value()),
            $this->documentFactory()->createSource($id, self::SOURCE_NAME),
            $this->documentFactory()->createLanguage($language),
            $this->documentFactory()->createKeywordCollection(...$keywords),
            $this->documentFactory()->createAuthor($authorName, $authorLocation),
            $this->documentFactory()->createLinkCollection(...$links),
            $this->documentFactory()->createHashtagCollection(...$hashtags),
            $this->documentFactory()->createTextCollection(...$texts),
            $this->documentFactory()->createImageCollection(...$images),
            $this->documentFactory()->createCreatedAt($createdAtDateTime->format(DATE_ATOM))
        );
    }

    /**
     * @return DocumentFactory
     */
    public function documentFactory(): DocumentFactory
    {
        return $this->documentFactory;
    }

    /**
     * @param $recordDecoded
     * @return array
     */
    private function getRelatedLinks($recordDecoded): array
    {
        $links = [];
        foreach ($recordDecoded->entities->urls as $currentUrl) {
            $links[] = $this->documentFactory()->createLink(LinkType::RELATED, $currentUrl->url);
        }

        return $links;
    }

    /**
     * @param $recordDecoded
     * @return array
     */
    private function getHashtags($recordDecoded): array
    {
        $hashtags = [];
        foreach ($recordDecoded->entities->hashtags as $currentHashtag) {
            $hashtags[] = $this->documentFactory()->createHashtag($currentHashtag->text);
        }

        return $hashtags;
    }
}
