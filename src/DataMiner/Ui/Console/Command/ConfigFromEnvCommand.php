<?php

namespace Mpwar\DataMiner\Ui\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigFromEnvCommand extends Command
{
    protected function configure()
    {
        $this->setName('setup:env')->setDescription('Write config application based on environments parameters');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $twitterConsumerKey       = getenv("TWITTER_CONSUMER_KEY");
        $twitterConsumerSecret    = getenv("TWITTER_CONSUMER_SECRET");
        $twitterAccessToken       = getenv("TWITTER_ACCESS_TOKEN");
        $twitterAccessTokenSecret = getenv("TWITTER_ACCESS_SECRET");
        $awsKey                   = getenv("AWS_KEY");
        $awsSecret                = getenv("AWS_SECRET");
        $amazonSqsUrl             = getenv("AMAZON_SQS_URL");
        $mongoUrl                 = getenv("MONGO_URL");

        $configBuffer = file_get_contents(__DIR__ . '/../../../../../resources/config/config.sample.yml');
        $configBuffer = str_replace("TWITTER_CONSUMER_KEY", $twitterConsumerKey, $configBuffer);
        $configBuffer = str_replace("TWITTER_CONSUMER_SECRET", $twitterConsumerSecret, $configBuffer);
        $configBuffer = str_replace("TWITTER_ACCESS_TOKEN", $twitterAccessToken, $configBuffer);
        $configBuffer = str_replace("TWITTER_ACCESS_SECRET", $twitterAccessTokenSecret, $configBuffer);
        $configBuffer = str_replace("AWS_KEY", $awsKey, $configBuffer);
        $configBuffer = str_replace("AWS_SECRET", $awsSecret, $configBuffer);
        $configBuffer = str_replace("AMAZON_SQS_URL", $amazonSqsUrl, $configBuffer);
        $configBuffer = str_replace("MONGO_URL", $mongoUrl, $configBuffer);

        if (!file_put_contents(__DIR__ . '/../../../../../resources/config/config.yml', $configBuffer)) {
            $output->writeln('Unable to write config file');
        }
    }

}
