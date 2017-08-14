<?php

namespace Mpwar\DataMiner\Domain;

class Image
{
    /**
     * @var LinkUrl
     */
    private $url;
    /**
     * @var Text
     */
    private $text;

    public function __construct(LinkUrl $url, Text $text)
    {
        $this->url  = $url;
        $this->text = $text;
    }

    /**
     * @return LinkUrl
     */
    public function url(): LinkUrl
    {
        return $this->url;
    }

    /**
     * @return Text
     */
    public function text(): Text
    {
        return $this->text;
    }
}
