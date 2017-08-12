<?php

namespace Mpwar\DataMiner\Domain\Service\SocialNetwork;

use Abraham\TwitterOAuth\TwitterOAuth;
use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\LastRecordVisited;
use Mpwar\DataMiner\Domain\Service\Service;
use Mpwar\DataMiner\Domain\Service\ServiceName;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;
use Mpwar\DataMiner\Domain\Service\ResultCollection;
use Mpwar\DataMiner\Domain\Service\Visit;
use Mpwar\DataMiner\Domain\Service\ServiceVisitsRepository;

class Twitter extends Service
{

    const SERVICE_NAME = 'twitter';
    private $client;

    public function __construct(
        ServiceVisitsRepository $visitsRepository,
        $consumer_key,
        $consumer_secret,
        $access_token,
        $access_token_secret
    ) {
        parent::__construct(
            new ServiceName(self::SERVICE_NAME)
        );

        $this->client = new TwitterOAuth(
            $consumer_key, $consumer_secret, $access_token, $access_token_secret
        );
    }

    public function findSince(
        Keyword $keyword,
        ?Visit $serviceVisit
    ): ResultCollection {

        $lastRecordVisited = ($serviceVisit) ? $serviceVisit->lastRecordVisited() : null;

        $requestParameters      = [];
        $requestParameters['q'] = $keyword->value();

        if ($lastRecordVisited) {
            $requestParameters['since_id'] = $lastRecordVisited->value();
        }

        $response = $this->client->get("search/tweets", $requestParameters);

        $serviceRecordsCollection = new ResultCollection();

        foreach ($response->statuses as $tweet) {
            $serviceRecordsCollection->add($this->createServiceRecord($keyword, json_encode($tweet)));
        }

        $serviceRecordsCollection->setLastRecordVisited(
            'max_id_str',
            $response->search_metadata->max_id_str
        );

        return $serviceRecordsCollection;
    }
}
