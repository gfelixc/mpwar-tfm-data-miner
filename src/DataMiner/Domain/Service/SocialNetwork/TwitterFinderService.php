<?php

namespace Mpwar\DataMiner\Domain\Service\SocialNetwork;

use Abraham\TwitterOAuth\TwitterOAuth;
use Mpwar\DataMiner\Domain\Keyword;
use Mpwar\DataMiner\Domain\Service\FinderService;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;
use Mpwar\DataMiner\Domain\Service\ServiceRecordsCollection;

class TwitterFinderService implements FinderService
{
    private $client;

    public function __construct($consumerKey, $consumerSecret, $oauthToken, $oauthTokenSecret)
    {
        $this->client = new TwitterOAuth($consumerKey, $consumerSecret, $oauthToken, $oauthTokenSecret);
    }

    public function find(Keyword $keyword): ServiceRecordsCollection
    {
        $requestParameters      = [];
        $requestParameters['q'] = $keyword->value();

        $response = $this->client->get("search/tweets", $requestParameters);

        $serviceRecordsCollection = new ServiceRecordsCollection();

        foreach ($response->statuses as $tweet) {
            $serviceRecordsCollection->add(
                new ServiceRecord(json_encode($tweet))
            );
        }

        return $serviceRecordsCollection;
    }
}
