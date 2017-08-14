<?php

namespace Mpwar\DataMiner\Domain\Service\SocialNetwork;

use Abraham\TwitterOAuth\TwitterOAuth;
use AntPack\DataTypes\Common\Language;
use Mpwar\DataMiner\Domain\Document;
use Mpwar\DataMiner\Domain\DocumentFactory;
use Mpwar\DataMiner\Domain\DocumentId;
use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\LinkType;
use Mpwar\DataMiner\Domain\Service\LastRecordVisited;
use Mpwar\DataMiner\Domain\Service\Service;
use Mpwar\DataMiner\Domain\Service\ServiceName;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;
use Mpwar\DataMiner\Domain\Service\ServiceRecordsCollection;
use Mpwar\DataMiner\Domain\Service\ServiceVisitsRepository;

class Twitter extends Service
{

    const SERVICE_NAME = 'twitter';
    private $client;

    public function __construct(
        ServiceVisitsRepository $visitsRepository,
        DocumentFactory $documentFactory,
        $consumer_key,
        $consumer_secret,
        $access_token,
        $access_token_secret
    ) {
        parent::__construct(
            new ServiceName(self::SERVICE_NAME),
            $visitsRepository,
            $documentFactory
        );

        $this->client = new TwitterOAuth(
            $consumer_key, $consumer_secret, $access_token, $access_token_secret
        );
    }

    public function parse(ServiceRecord $record, Keyword $searchedKeyword): Document
    {
        $recordDecoded = json_decode($record->value());

        $id             = $recordDecoded->id;
        $language       = (in_array($recordDecoded->metadata->iso_language_code, Language::ISO_639_1_CODES)) ?
            $recordDecoded->metadata->iso_language_code : Language::UNKNOWN;
        $keywords       = [
            $this->documentFactory()->createKeyword($searchedKeyword->value())
        ];
        $authorName     = $recordDecoded->user->name;
        $authorLocation = $recordDecoded->user->location;
        $directUrl      = sprintf("https://twitter.com/%s/status/%d", $recordDecoded->user->screen_name, $id);
        $links          = [
            $this->documentFactory()->createLink(LinkType::DIRECT, $directUrl)
        ];
        foreach ($recordDecoded->entities->urls as $currentUrl) {
            $links[] = $this->documentFactory()->createLink(LinkType::RELATED, $currentUrl->url);
        }
        $hashtags = [];
        foreach ($recordDecoded->entities->hashtags as $currentHashtag) {
            $hashtags[] = $this->documentFactory()->createHashtag($currentHashtag->text);
        }
        $texts = [
            $this->documentFactory()->createText($recordDecoded->text)
        ];
        $images = [
            $this->documentFactory()->createImage($recordDecoded->user->profile_image_url, 'Profile image')
        ];
        $createdAt = \DateTime::createFromFormat("D M d H:i:s O Y", $recordDecoded->created_at)->format(DATE_ATOM);

        return $this->documentFactory()->createDocument(
            $this->documentFactory()->createDocumentId(DocumentId::new()->value()),
            $this->documentFactory()->createSource($id, self::SERVICE_NAME),
            $this->documentFactory()->createLanguage($language),
            $this->documentFactory()->createKeywordCollection(...$keywords),
            $this->documentFactory()->createAuthor($authorName, $authorLocation),
            $this->documentFactory()->createLinkCollection(...$links),
            $this->documentFactory()->createHashtagCollection(...$hashtags),
            $this->documentFactory()->createTextCollection(...$texts),
            $this->documentFactory()->createImageCollection(...$images),
            $this->documentFactory()->createCreatedAt($createdAt)
        );
    }

    protected function findSince(
        Keyword $keyword,
        ?LastRecordVisited $serviceVisit
    ): ServiceRecordsCollection {

        $requestParameters      = [];
        $requestParameters['q'] = $keyword->value();

        if ($serviceVisit) {
            $requestParameters['since_id'] = $serviceVisit->value();
        }

        $response = $this->client->get("search/tweets", $requestParameters);

        $serviceRecordsCollection = new ServiceRecordsCollection();

        foreach ($response->statuses as $tweet) {
            $serviceRecordsCollection->add(
                new ServiceRecord(json_encode($tweet))
            );
        }

        $serviceRecordsCollection->setLastRecordVisited(
            'max_id_str',
            $response->search_metadata->max_id_str
        );

        return $serviceRecordsCollection;
    }
}
