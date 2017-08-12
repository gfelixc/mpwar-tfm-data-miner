<?php

namespace Mpwar\DataMiner\Domain;

class DomainEventPublisher
{
    /**
     * @var DomainEventPublisher
     */
    private static $instance;

    /**
     * @var Collection
     */
    private $subscribers;

    /**
     * @var boolean
     */
    private $publishing;

    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function publish($event)
    {
        if (!$this->isPublishing() && $this->hasSubscribers()) {
            try {
                $this->setPublishing(true);
                $eventType = get_class($event);

                $allSubscribers = $this->subscribers();

                foreach ($allSubscribers as $subscriber) {
                    $subscribedToType = $subscriber->subscribedToEventType();

                    if ($eventType === $subscribedToType || $subscribedToType == 'SaasOvation\Common\Domain\Model\DomainEvent') {
                        $subscriber->handleEvent($event);
                    }
                }
            } finally {
                $this->setPublishing(false);
            }
        }
    }

    public function publishAll(Collection $aDomainEvents)
    {
        foreach ($aDomainEvents as $domainEvent) {
            $this->publish($domainEvent);
        }
    }

    public function reset()
    {
        if (!$this->isPublishing()) {
            $this->subscribers = null;
        }
    }

    public function subscribe(DomainEventSubscriber $aSubscriber)
    {
        if (!$this->isPublishing()) {
            $this->ensureSubscribersList();

            $this->subscribers()->add($aSubscriber);
        }
    }

    private function __construct()
    {
        $this->setPublishing(false);
        $this->ensureSubscribersList();
    }

    private function ensureSubscribersList()
    {
        if (!$this->hasSubscribers()) {
            $this->setSubscribers(new ArrayCollection());
        }
    }

    private function hasSubscribers()
    {
        return null !== $this->subscribers();
    }

    private function subscribers()
    {
        return $this->subscribers;
    }

    private function setSubscribers(Collection $aSubscriberList)
    {
        $this->subscribers = $aSubscriberList;
    }

    private function setPublishing($isPublishing)
    {
        $this->publishing = $isPublishing;
    }

    private function isPublishing()
    {
        return $this->publishing;
    }
}
