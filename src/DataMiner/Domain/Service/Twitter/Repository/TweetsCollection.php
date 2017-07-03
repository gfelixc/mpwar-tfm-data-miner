<?php

namespace Mpwar\DataMiner\Domain\Service\Twitter\Repository;

class TweetsCollection
{
    private $tweets;
    private $maxId;

    public function __construct($tweets, $maxId)
    {
        $this->tweets = $tweets;
        $this->maxId = $maxId;
    }

    /**
     * @return mixed
     */
    public function tweets()
    {
        return $this->tweets;
    }

    /**
     * @return mixed
     */
    public function maxId()
    {
        return $this->maxId;
    }
}
