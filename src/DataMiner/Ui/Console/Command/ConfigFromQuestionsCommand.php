<?php

namespace Mpwar\DataMiner\Ui\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ConfigFromQuestionsCommand extends Command
{
    protected function configure()
    {
        $this->setName('setup:questions')->setDescription('Interactive questions to config application parameters');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $twitterConsumerKey       = $this->askTwitterConsumerKey($input, $output, $helper);
        $twitterConsumerSecret    = $this->askTwitterConsumerSecret($input, $output, $helper);
        $twitterAccessToken       = $this->askTwitterAccessToken($input, $output, $helper);
        $twitterAccessTokenSecret = $this->askTwitterAccessTokenSecret($input, $output, $helper);
        $awsKey                   = $this->askAwsKey($input, $output, $helper);
        $awsSecret                = $this->askAwsSecret($input, $output, $helper);
        $amazonSqsUrl             = $this->askAmazonSqsUrl($input, $output, $helper);
        $mongoUrl                 = $this->askMongoUrl($input, $output, $helper);

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

    protected function askTwitterConsumerKey(InputInterface $input, OutputInterface $output, QuestionHelper $helper)
    {
        $twitterConsumerKeyQuestion = new Question('Please enter the TWITTER_CONSUMER_KEY: ', null);
        $twitterConsumerKeyQuestion->setValidator(
            function ($answer) {
                if ($answer == null) {
                    throw new \RuntimeException('The TWITTER_CONSUMER_KEY cannot be null');
                }

                return $answer;
            }
        );
        $twitterConsumerKeyQuestion->setMaxAttempts(2);
        $twitterConsumerKeyAnswer = $helper->ask($input, $output, $twitterConsumerKeyQuestion);

        return $twitterConsumerKeyAnswer;
    }

    protected function askTwitterConsumerSecret(InputInterface $input, OutputInterface $output, QuestionHelper $helper)
    {
        $twitterConsumerSecretQuestion = new Question('Please enter the TWITTER_CONSUMER_SECRET: ', null);
        $twitterConsumerSecretQuestion->setValidator(
            function ($answer) {
                if ($answer == null) {
                    throw new \RuntimeException('The TWITTER_CONSUMER_SECRET cannot be null');
                }

                return $answer;
            }
        );
        $twitterConsumerSecretQuestion->setMaxAttempts(2);
        $twitterConsumerSecretAnswer = $helper->ask($input, $output, $twitterConsumerSecretQuestion);

        return $twitterConsumerSecretAnswer;
    }

    protected function askTwitterAccessToken(InputInterface $input, OutputInterface $output, QuestionHelper $helper)
    {
        $twitterAccessTokenQuestion = new Question('Please enter the TWITTER_ACCESS_TOKEN: ', null);
        $twitterAccessTokenQuestion->setValidator(
            function ($answer) {
                if ($answer == null) {
                    throw new \RuntimeException('The TWITTER_ACCESS_TOKEN cannot be null');
                }

                return $answer;
            }
        );
        $twitterAccessTokenQuestion->setMaxAttempts(2);

        $twitterAccessTokenAnswer = $helper->ask($input, $output, $twitterAccessTokenQuestion);

        return $twitterAccessTokenAnswer;
    }

    protected function askTwitterAccessTokenSecret(InputInterface $input, OutputInterface $output, QuestionHelper $helper)
    {
        $twitterAccessTokenSecretQuestion = new Question('Please enter the TWITTER_ACCESS_TOKEN_SECRET: ', null);
        $twitterAccessTokenSecretQuestion->setValidator(
            function ($answer) {
                if ($answer == null) {
                    throw new \RuntimeException('The TWITTER_ACCESS_TOKEN_SECRET cannot be null');
                }

                return $answer;
            }
        );
        $twitterAccessTokenSecretQuestion->setMaxAttempts(2);
        $twitterAccessTokenSecretAnswer = $helper->ask($input, $output, $twitterAccessTokenSecretQuestion);

        return $twitterAccessTokenSecretAnswer;
    }

    protected function askAwsKey(InputInterface $input, OutputInterface $output, QuestionHelper $helper)
    {
        $awsKeyQuestion = new Question('Please enter the AWS_KEY: ', null);
        $awsKeyQuestion->setValidator(
            function ($answer) {
                if ($answer == null) {
                    throw new \RuntimeException('The AWS_KEY cannot be null');
                }

                return $answer;
            }
        );
        $awsKeyQuestion->setMaxAttempts(2);
        $awsKeyAnswer = $helper->ask($input, $output, $awsKeyQuestion);

        return $awsKeyAnswer;
    }

    protected function askAwsSecret(InputInterface $input, OutputInterface $output, QuestionHelper $helper)
    {
        $awsSecretQuestion = new Question('Please enter the AWS_SECRET: ', null);
        $awsSecretQuestion->setValidator(
            function ($answer) {
                if ($answer == null) {
                    throw new \RuntimeException('The AWS_SECRET cannot be null');
                }

                return $answer;
            }
        );
        $awsSecretQuestion->setMaxAttempts(2);
        $awsSecretAnswer = $helper->ask($input, $output, $awsSecretQuestion);

        return $awsSecretAnswer;
    }

    protected function askAmazonSqsUrl(InputInterface $input, OutputInterface $output, QuestionHelper $helper)
    {
        $amazonSqsUrlQuestion = new Question('Please enter the AMAZON_SQS_URL: ', null);
        $amazonSqsUrlQuestion->setValidator(
            function ($answer) {
                if ($answer == null) {
                    throw new \RuntimeException('The AMAZON_SQS_URL cannot be null');
                }

                return $answer;
            }
        );
        $amazonSqsUrlQuestion->setMaxAttempts(2);
        $amazonSqsUrlAnswer = $helper->ask($input, $output, $amazonSqsUrlQuestion);

        return $amazonSqsUrlAnswer;
    }

    protected function askMongoUrl(InputInterface $input, OutputInterface $output, QuestionHelper $helper)
    {
        $mongoUrlQuestion = new Question('Please enter the MONGO_URL: ', null);
        $mongoUrlQuestion->setValidator(
            function ($answer) {
                if ($answer == null) {
                    throw new \RuntimeException('The MONGO_URL cannot be null');
                }

                return $answer;
            }
        );
        $mongoUrlQuestion->setMaxAttempts(2);
        $mongoUrlAnswer = $helper->ask($input, $output, $mongoUrlQuestion);

        return $mongoUrlAnswer;
    }
}
