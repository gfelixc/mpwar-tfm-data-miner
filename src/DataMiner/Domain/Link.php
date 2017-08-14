<?php

namespace Mpwar\DataMiner\Domain;

class Link
{
    /**
     * @var LinkType
     */
    private $type;
    /**
     * @var LinkUrl
     */
    private $url;

    public function __construct(LinkType $type, LinkUrl $url)
    {
        $this->type = $type;
        $this->url  = $url;
    }

    /**
     * @return LinkType
     */
    public function type(): LinkType
    {
        return $this->type;
    }

    /**
     * @return LinkUrl
     */
    public function url(): LinkUrl
    {
        return $this->url;
    }
}
