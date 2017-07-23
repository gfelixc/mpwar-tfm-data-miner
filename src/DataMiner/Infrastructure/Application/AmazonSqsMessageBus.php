<?php

namespace Mpwar\DataMiner\Infrastructure\Application;

use Aws\Sqs\SqsClient;
use Mpwar\DataMiner\Application\MessageBus;

class AmazonSqsMessageBus implements MessageBus
{
    private $client;
    private $queueUrl;

    public function __construct(SqsClient $awsClient, $queueUrl)
    {
        $this->client = $awsClient;
        $this->queueUrl = $queueUrl;
    }

    public function dispatch(string $message)
    {
        $this->client->sendMessage(
            [
                'QueueUrl' => $this->queueUrl,
                'MessageBody' => $message
            ]
        );
    }
}
