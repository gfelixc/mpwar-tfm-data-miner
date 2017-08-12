<?php

namespace Mpwar\DataMiner\Domain\Service\SocialNetwork;

use Abraham\TwitterOAuth\TwitterOAuth;
use Mpwar\DataMiner\Domain\DomainEventPublisher;
use Mpwar\DataMiner\Domain\Keyword\Keyword;
use Mpwar\DataMiner\Domain\Service\ResultWasFoundEvent;
use Mpwar\DataMiner\Domain\Service\ServiceName;
use Mpwar\DataMiner\Domain\Service\ServiceRecord;
use Mpwar\DataMiner\Domain\Service\ResultCollection;
use Mpwar\DataMiner\Domain\Service\Visit;

class Service
{

    const NAME = 'twitter';
    private $client;
    private $name;

    public function __construct(
        $consumer_key,
        $consumer_secret,
        $access_token,
        $access_token_secret
    ) {
        $this->setName(new ServiceName(self::NAME));

        $this->client = new TwitterOAuth(
            $consumer_key, $consumer_secret, $access_token, $access_token_secret
        );
    }

    private function setName(ServiceName $serviceName): void
    {
        $this->name = $serviceName;
    }

    public function findSince(Keyword $keyword, Visit $lastVisit): ResultCollection
    {
        $requestParameters      = [];
        $requestParameters['q'] = $keyword->value();

        if ($lastVisit) {
            $requestParameters['since_id'] = $lastVisit->value();
        }

        $response = $this->client->get("search/tweets", $requestParameters);

        $resultCollection = new ResultCollection();

        foreach ($response->statuses as $tweet) {
            $resultCollection->add($this->createServiceRecord($keyword, json_encode($tweet)));
        }

        $resultCollection->setLastRecordVisited(
            'max_id_str',
            $response->search_metadata->max_id_str
        );

        return $resultCollection;
    }

    protected function createServiceRecord(Keyword $keyword, string $data): ServiceRecord
    {

        $serviceRecord = new ServiceRecord($data);

        $event = new ResultWasFoundEvent($this->name(), $keyword->value(), $data);
        DomainEventPublisher::instance()->publish($event);

        return $serviceRecord;
    }

    public function name(): ServiceName
    {
        return $this->name;
    }
}
